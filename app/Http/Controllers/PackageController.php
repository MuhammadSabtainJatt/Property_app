<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\UserPurchasedPackage;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!has_permissions('read', 'package')) {
            return redirect()->back()->with('error', PERMISSION_ERROR_MSG);
        }
        $slider = Slider::select('id', 'image', 'sequence')->orderBy('sequence', 'ASC')->get();

        $category = Category::select('id', 'category')->where('status', 1)->get();
        $currency_symbol = Setting::where('type', 'currency_symbol')->pluck('data')->first();

        return view('packages.index', compact('slider', 'category', 'currency_symbol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if (!has_permissions('create', 'package')) {
            return redirect()->back()->with('error', PERMISSION_ERROR_MSG);
        } else {


            $package = new Package();


            $package->name = $request->name;
            $package->duration = isset($request->duration) ? $request->duration : 0;
            $package->price = $request->price;
            if (isset($request->typep)) {
                $package->property_limit =  $request->property_limit == NULL ? NULL : $request->property_limit;
            } else {
                $package->property_limit = 0;
            }

            if (isset($request->typel)) {
                $package->advertisement_limit =  $request->advertisement_limit == NULL ? NULL : $request->advertisement_limit;
            } else {
                $package->advertisement_limit = 0;
            }


            $package->save();


            return back()->with('success', 'Package Successfully Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        }



        $sql = Package::orderBy($sort, $order);
        // dd($sql->toArray());


        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")->orwhere('name', 'LIKE', "%$search%")->orwhere('duration', 'LIKE', "%$search%");
        }


        $total = $sql->count();

        if (isset($_GET['limit'])) {
            $sql->skip($offset)->take($limit);
        }


        $res = $sql->get();
        // return $res;
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;


        $operate = '';
        $tempRow['type'] = '';
        $parameter_name_arr = [];


        foreach ($res as $row) {
            $tempRow['id'] = $row->id;
            $tempRow['name'] = $row->name;
            $tempRow['duration'] = $row->duration;
            $tempRow['price'] = $row->price;
            $tempRow['property_limit'] = $row->property_limit == '' ?  "unlimited" : ($row->property_limit == 0 ? "Not Available" : $row->property_limit);
            $tempRow['advertisement_limit'] = $row->advertisement_limit == '' ? "unlimited" : ($row->advertisement_limit == 0 ? "Not Available" : $row->advertisement_limit);

            $tempRow['status'] = ($row->status == '0') ? '<span class="badge rounded-pill bg-danger">OFF</span>' : '<span class="badge rounded-pill bg-success">ON</span>';



            $tempRow['status'] = ($row->status == '0') ? '<span class="badge rounded-pill bg-danger">OFF</span>' : '<span class="badge rounded-pill bg-success">ON</span>';

            $operate = '&nbsp;&nbsp;<a  id="' . $row->id . '"  class="btn icon btn-primary btn-sm rounded-pill mt-2 edit_btn"  data-bs-toggle="modal" data-bs-target="#editModal"  onclick="setValue(this.id);"  title="Edit"><i class="fa fa-edit edit_icon"></i></a>';



            $status = $row->status == '1' ? 'checked' : '';
            $enable_disable =   '<div class="form-check form-switch" style="padding-left: 5.2rem;">
         <input class="form-check-input switch1" id="' . $row->id . '"  onclick="chk(this);" type="checkbox" role="switch"' . $status . '>

            </div>';

            $tempRow['enble_disable'] = $enable_disable;

            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (!has_permissions('update', 'package')) {
            return redirect()->back()->with('error', PERMISSION_ERROR_MSG);
        } else {
            // dd($request->input());

            $id = $request->edit_id;
            $name =  $request->edit_name;
            $duration =  $request->edit_duration;
            $price =  $request->edit_price;

            $package = Package::find($id);

            $package->name = $name;
            $package->duration = $duration;
            $package->price = $price;
            $package->property_limit = $request->property_limit === NULL ? NULL : $request->property_limit;
            $package->advertisement_limit = $request->advertisement_limit ===  NULL ? NULL : $request->advertisement_limit;
            $package->status = $request->status;
            $package->update();

            $user_package = UserPurchasedPackage::where('package_id', $id)->get();

            foreach ($user_package as $package) {
                $start_date = new DateTime($package->start_date);

                $start_date->add(new DateInterval("P" . $duration . "D"));

                $new_end_date = $start_date->format("Y-m-d");
                $package->end_date = $new_end_date;
                $package->save();
            }



            return back()->with('success', 'Package Successfully Update');
        }
    }
    public function updateStatus(Request $request)
    {
        if (!has_permissions('update', 'package')) {
            $response['error'] = true;
            $response['message'] = PERMISSION_ERROR_MSG;
            return response()->json($response);
        } else {
            Package::where('id', $request->id)->update(['status' => $request->status]);
            $response['error'] = false;
            return response()->json($response);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_user_package_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        }

        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }

        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        }



        $sql = UserPurchasedPackage::with('package')->with('customer')->orderBy($sort, $order);
        // dd($sql->toArray());


        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")->orwherehas('customer', function ($q1) use ($search) {
                $q1->where('name', 'LIKE', "%$search%");
            })->orwherehas('package', function ($q1) use ($search) {
                $q1->where('name', 'LIKE', "%$search%")->orwhere('duration', 'LIKE', "%$search%");
            });;
        }


        $total = $sql->count();

        if (isset($_GET['limit'])) {
            $sql->skip($offset)->take($limit);
        }


        $res = $sql->get();
        // return $res;
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $count = 1;


        $operate = '';
        $tempRow['type'] = '';

        foreach ($res as $row) {
            $tempRow['id'] = $row->id;
            $tempRow['start_date'] = date('d-m-Y', strtotime($row->start_date));
            $tempRow['end_date'] = date('d-m-Y', strtotime($row->end_date));
            $tempRow['subscription'] = $row->customer->subscription == 1 ? 'On' : 'Off';
            $tempRow['name'] = $row->package->name;
            $tempRow['customer_name'] = !empty($row->customer) ? $row->customer->name : '';
            $rows[] = $tempRow;
            $count++;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }
}
