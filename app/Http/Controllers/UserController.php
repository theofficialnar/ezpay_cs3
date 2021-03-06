<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\taxes;
use App\sss_contribs;
use App\philhealth_contribs;
use DB;

class UserController extends Controller
{   

    //controls users displayed on the list
    function filterUsers(Request $request){
        if(!empty($request)){
            $selected = $request->selected;
            if($selected == 0){
                $users = DB::table('users')->paginate(15);
            }elseif($selected == 1){
                $users = DB::table('users')
                        ->where('status', '=', '0')
                        ->orWhere('status', '=', '1')
                        ->paginate(15);
            }else{
                $users = DB::table('users')
                        ->where('status', '=', '2')
                        ->orWhere('status', '=', '3')
                        ->paginate(15);
            }
            return view('/pages/admin_panel', compact('users', 'selected'));
        }else{
            $users = DB::table('users')->paginate(15);
    	    return view('/pages/admin_panel', compact('users'));
        }
        
    }

    //add new user function
    function addUser(Request $request){
    	$new_user = new User;
    	$new_user->name = $request->name;
    	$new_user->department = $request->dept;
    	$new_user->position = $request->post;
        $new_user->salary = $request->sal;
    	$new_user->date_started = $request->hired;
    	$new_user->address = $request->add;
    	$new_user->birthday = $request->bday;
    	$new_user->marital_status = $request->mar_stat;
    	$new_user->status = $request->stat;
    	$new_user->bank_info = $request->bank;
    	$new_user->email = $request->email;
    	$new_user->password = bcrypt('123456');
        $new_user->dependents = $request->dependents;
        $new_user->hrs_per_day = '8';
        $new_user->days_per_week = $request->days_week;
    	$new_user->save();
    	return back();
    }

    //view user info and edit info via modal
    function adminViewUser($id){
    	$user = User::find($id);
    	echo '
        <div class="tab-content">
            <div id="tabUserInfo" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1>'.$user->name.'</h1>
                        <p><span class="payrollLabel">ID Number: </span>'.$user->id.'</p>
                        <hr>
                    </div>
                    <div class="col-lg-7">
                        <p><span class="payrollLabel">Email: </span>'.$user->email.'</p>
                    </div>
                    <div class="col-lg-5">';
                    if($user->status == 0){
                        echo'<p><span class="payrollLabel">Status: </span> <span class="userActive">Active</span></p>';
                    }elseif($user->status == 1){
                        echo'<p><span class="payrollLabel">Status: </span> <span class="userOOO">On Leave</span></p>';
                    }elseif($user->status == 2){
                        echo'<p><span class="payrollLabel">Status: </span> <span class="userInactive">Retired</span></p>';
                    }else{
                        echo'<p><span class="payrollLabel">Status: </span> <span class="userInactive">Terminated</span></p>';
                    }
                    echo '</div>
                    <div class="col-lg-7">
                        <p><span class="payrollLabel">Department: </span>'.$user->department.'</p>
                    </div>
                    <div class="col-lg-5">
                        <p><span class="payrollLabel">Position: </span>'.$user->position.'</p>
                    </div>
                    <div class="col-lg-7">
                        <p><span class="payrollLabel">Salary: </span>Php '.number_format($user->salary, 2, '.', ',').'</p>
                    </div>
                    <div class="col-lg-5">
                        <p><span class="payrollLabel">Date Hired: </span>'.date('F j, Y', strtotime($user->date_started)).'</p>
                    </div>
                    <div class="col-lg-7">
                        <p><span class="payrollLabel">Hours per Day: </span>'.$user->hrs_per_day.' hours</p>
                    </div>
                    <div class="col-lg-5">
                        <p><span class="payrollLabel">Days per Week: </span>'.$user->days_per_week.' days</p>
                    </div>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg-12">
                        <p><span class="payrollLabel">Address: </span>'.$user->address.'</p>
                    </div>
                    <div class="col-lg-7">
                        <p><span class="payrollLabel">Birthday: </span>'.date('F j, Y', strtotime($user->birthday)).'</p>
                    </div>
                    <div class="col-lg-5">
                        <p><span class="payrollLabel">Bank Info: </span>'.$user->bank_info.'</p>
                    </div>
                    <div class="col-lg-7">';
                    if($user->marital_status == 0){
                        echo '<p><span class="payrollLabel">Marital Status: </span>Single</p>';
                    }else{
                        echo '<p><span class="payrollLabel">Marital Status: </span>Married</p>';
                    }
                    echo '</div>
                    <div class="col-lg-5">
                        <p><span class="payrollLabel">Number of Dependents: </span>'.$user->dependents.'</p>
                    </div>   
                </div>
            </div>

            <div id="tabUserUpdate" class="tab-pane fade topPadding">
                <form id="userUpdate">
                    <input type="hidden" value="'.$user->id.'" id="userEditId">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label>Status: &nbsp;</label>';
                            if($user->status == 0){
                                echo'<label class="radio-inline">
                                <input type="radio" name="stat" value="0" checked>Active</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="1">On Leave</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="2">Retired</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="3">Terminated</label>';
                            }elseif($user->status == 1){
                                echo'<label class="radio-inline">
                                <input type="radio" name="stat" value="0">Active</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="1" checked>On Leave</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="2">Retired</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="3">Terminated</label>';
                            }elseif($user->status == 2){
                                echo'<label class="radio-inline">
                                <input type="radio" name="stat" value="0">Active</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="1">On Leave</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="2" checked>Retired</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="3">Terminated</label>';
                            }else{
                                echo'<label class="radio-inline">
                                <input type="radio" name="stat" value="0">Active</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="1">On Leave</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="2">Retired</label>
                                <label class="radio-inline">
                                <input type="radio" name="stat" value="3" checked>Terminated</label>';
                            }
                        echo'</div>
                        <div class="form-group col-lg-6">
                            <label for="edit_usr">Name:</label>
                            <input type="text" name="name" value="'.$user->name.'" id="edit_usr" class="form-control">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_sal">Salary:</label>
                            <input type="number" class="form-control" id="edit_sal" name="sal" value="'.$user->salary.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_dept">Department:</label>
                            <input type="text" class="form-control" id="edit_dept" name="dept" value="'.$user->department.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_pos">Position:</label>
                            <input type="text" class="form-control" id="edit_pos" name="pos" value="'.$user->position.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_days_week">Days Per Week: &nbsp;</label><br>';
                            if($user->days_per_week == 5){
                                echo'<label class="radio-inline">
                                <input required type="radio" name="days_week" value="5" checked>5 Days</label>
                                <label class="radio-inline">
                                <input required type="radio" name="days_week" value="6">6 Days</label>';
                            }else{
                                echo'<label class="radio-inline">
                                <input required type="radio" name="days_week" value="5">5 Days</label>
                                <label class="radio-inline">
                                <input required type="radio" name="days_week" value="6" checked>6 Days</label>';
                            }
                        echo '</div>
                        <div class="form-group col-lg-6">
                            <label for="edit_hired">Date Hired:</label>
                            <input type="date" class="form-control" id="edit_hired" name="hired" value="'.$user->date_started.'">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="edit_add">Address:</label>
                            <input type="text" class="form-control" id="edit_add" name="add" value="'.$user->address.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_bday">Birthday:</label>
                            <input type="date" class="form-control" id="edit_bday" name="bday" value="'.$user->birthday.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="edit_bank">Bank Account Number:</label>
                            <input type="number" class="form-control" id="edit_bank" name="bank_info" value="'.$user->bank_info.'">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Marital Status: &nbsp;</label><br>';
                            if($user->marital_status == 0){
                                echo '<label class="radio-inline">
                                <input type="radio" name="mar_stat" value="0" checked>Single</label>
                                <label class="radio-inline">
                                <input type="radio" name="mar_stat" value="1">Married</label>';
                            }else{
                                echo '<label class="radio-inline">
                                <input type="radio" name="mar_stat" value="0">Single</label>
                                <label class="radio-inline">
                                <input type="radio" name="mar_stat" value="1" checked>Married</label>';
                            }
                        echo '</div>
                        <div class="form-group col-lg-6">
                            <label for="edit_dependents">Dependents:</label>
                            <input type="number" class="form-control" id="edit_dependents" name="dependents" value="'.$user->dependents.'">
                        </div>
                    </div>
                </form>
                <hr>
                <div class="text-center">
                    <button id="saveUserEdit" data-dismiss="modal" class="btn btn-success" style="width: 45%"><span class="glyphicon glyphicon-floppy-save"></span><b> Save Changes</b></button>
                </div>
            </div>

            <div id="tabUserUpdatePw" class="tab-pane fade topPadding">
                <form id="acctUpdate">
                    <div class="form-group">
                        <label for="edit_email">Email:</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="'.$user->email.'" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Please input a valid email address.">
                    </div>
                    <div class="form-group">
                        <label for="edit_pw">New Password:</label>
                        <input type="password" class="form-control" id="edit_pw" name="pw">
                    </div>
                </form>
                <div class="text-center">
                    <button id="saveUserAcctEdit" data-dismiss="modal" class="btn btn-success" style="width: 45%"><span class="glyphicon glyphicon-floppy-save"></span><b> Save Changes</b></button>
                </div>
            </div>
        </div>';
    }

    //update user info via modal
    function adminUpdateUser($id, Request $request){
        $upd_user = User::find($id);
        $upd_user->name = $request->name;
        $upd_user->department = $request->dept;
        $upd_user->position = $request->pos;
        $upd_user->salary = $request->sal;
        $upd_user->date_started = $request->hired;
        $upd_user->address = $request->add;
        $upd_user->birthday = $request->bday;
        $upd_user->marital_status = $request->mar_stat;
        $upd_user->status = $request->stat;
        $upd_user->bank_info = $request->bank;
        $upd_user->days_per_week = $request->days_week;
        $upd_user->dependents = $request->dependents;
        $upd_user->save();

        $users = User::all();
        foreach($users as $user){
            echo '
            <tr>
                <td><a data-uid="'.$user->id.'" class="openUserPanel" href="#tabUserInfo">'.$user->name.'</a></td>
                <td>'.$user->department.'</td>
                <td>'.$user->position.'</td>';
                if($user->status == 0){
                    echo '<td class="userActive">Active</td>';
                }
                elseif($user->status == 1){
                    echo '<td class="userOOO">On Leave</td>';
                }
                elseif($user->status == 2){
                    echo '<td class="userInactive">Retired</td>';
                }
                else{
                    echo '<td class="userInactive">Terminated</td>';
                }
                if($user->status == 2 || $user->status == 3){
                    echo '<td><button class="btn btn-xs btn-default payrollModalTrigger disabled" data-uid="'.$user->id.'">Update Payroll</button></td>';
                }else{
                    echo '<td><button class="btn btn-xs btn-default payrollModalTrigger" data-uid="'.$user->id.'">Update Payroll</button></td>';
                }
            echo '</tr>';
        }
    }

    //Update user account info via modal
    function adminUpdateUserAcct($id, Request $request){
        $upd_user = User::find($id);
        $upd_user->email = $request->email;
        if(isset($request->password)){
            $upd_user->password = bcrypt($request->password);
        }
        $upd_user->save();
    }

    //Returns the payroll form
    function getPayrollForm($id){
        $pay_user = User::find($id);
        echo '
        <input type="hidden" id="payrollSal" value="'.$pay_user->salary.'" name="payrollSalary">
        <input type="hidden" id="payrollUid" value="'.$pay_user->id.'" name="payrollUid">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="text-center">Deductions</h4></div>
            <div class="panel-body">
                <div class="form-group col-lg-6">
                    <label for="hrs_absent">Absences (in days)</label>
                    <input type="number" id="hrs_absent" name="hrs_absent" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-6">
                    <label for="hrs_late">Lates</label>
                    <input type="number" id="hrs_late" name="hrs_late" class="form-control" value="0" min="0">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="text-center">Holidays and Rest Days</h4></div>
            <div class="panel-body">
                <div class="form-group col-lg-4">
                    <label for="hrs_rd">Rest Day</label>
                    <input type="number" id="hrs_rd" name="hrs_rd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_spec_holiday">Special Holiday</label>
                    <input type="number" id="hrs_spec_holiday" name="hrs_spec_holiday" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_spec_holiday_rd">Special Holiday AND Rest Day</label>
                    <input type="number" id="hrs_spec_holiday_rd" name="hrs_spec_holiday_rd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4 col-lg-offset-2">
                    <label for="hrs_reg_holiday">Regular Holiday</label>
                    <input type="number" id="hrs_reg_holiday" name="hrs_reg_holiday" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_reg_holiday_rd">Regular Holiday AND Rest Day</label>
                    <input type="number" id="hrs_reg_holiday_rd" name="hrs_reg_holiday_rd" class="form-control" value="0" min="0">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="text-center">Overtimes</h4></div>
            <div class="panel-body">
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_ord">Ordinary Overtime</label>
                    <input type="number" id="hrs_ot_ord" name="hrs_ot_ord" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_rd">Rest Day Overtime</label>
                    <input type="number" id="hrs_ot_rd" name="hrs_ot_rd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_spec_holiday">Special Holiday Overtime</label>
                    <input type="number" id="hrs_ot_spec_holiday" name="hrs_ot_spec_holiday" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_spec_holiday_rd">Special Holiday AND Rest Day Overtime</label>
                    <input type="number" id="hrs_ot_spec_holiday_rd" name="hrs_ot_spec_holiday_rd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_reg_holiday">Regular Holiday Overtime</label>
                    <input type="number" id="hrs_ot_reg_holiday" name="hrs_ot_reg_holiday" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_ot_reg_holiday_rd">Regular Holiday AND Rest Day Overtime</label>
                    <input type="number" id="hrs_ot_reg_holiday_rd" name="hrs_ot_reg_holiday_rd" class="form-control" value="0" min="0">
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="text-center">Night Differentials</h4></div>
            <div class="panel-body">
                <div class="form-group col-lg-4">
                    <label for="hrs_nd">Regular Night Differential</label>
                    <input type="number" id="hrs_nd" name="hrs_nd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_rd_nd">Rest Day Night Differential</label>
                    <input type="number" id="hrs_rd_nd" name="hrs_rd_nd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_spec_holiday_nd">Special Holiday Night Differential</label>
                    <input type="number" id="hrs_spec_holiday_nd" name="hrs_spec_holiday_nd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_spec_holiday_rd_nd">Rest Day AND Special Holiday Night Differential</label>
                    <input type="number" id="hrs_spec_holiday_rd_nd" name="hrs_spec_holiday_rd_nd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_reg_holiday_nd">Regular Holiday Night Differential</label>
                    <input type="number" id="hrs_reg_holiday_nd" name="hrs_reg_holiday_nd" class="form-control" value="0" min="0">
                </div>
                <div class="form-group col-lg-4">
                    <label for="hrs_reg_holiday_rd_nd">Regular Holiday AND Rest Day Night Differential</label>
                    <input type="number" id="hrs_reg_holiday_rd_nd" name="hrs_reg_holiday_rd_nd" class="form-control" value="0" min="0">
                </div>
            </div>
        </div>';
    }

    //Returns the contribution table
    function showTables(){
        $tax_table = Taxes::all();
        $sss_table = sss_contribs::all();
        $phil_table = philhealth_contribs::all();
        return view('/pages/admin_settings', compact('tax_table'));
    }


}