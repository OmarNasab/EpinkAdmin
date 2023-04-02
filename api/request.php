<?php
include("speedy.php");
$pdfkey = 'ClxsZUiUlVj2';
if (isset($_POST["delyvagetquote"])) {
    include("delyva.php");
    $json = json_decode(base64_decode($_POST["delyvagetquote"]));
    $origin = $json->origin;

    $destination = $json->destination;
    $weight = $json->weight;
    $dimension = $json->dimension;
    $delyva = new Delyva;
    $accessToken = $delyva->auth();
    if ($accessToken == 'error') {
        $data["status"] = "fail";
        $data["message"] = "Unauthenticated";
    } else {
        sleep(1);
        $request = $delyva->getQuote($origin, $destination, $weight, $dimension);
        if ($request == null) {
            $data["status"] = "fail";
            $data["request"] = $request;
            $data["message"] = "Failed to get quotation from delyva";
        } else {

            $data["distance"] = getDistance($origin->coord->lat, $origin->coord->lon, $destination->coord->lat, $destination->coord->lon, "K");
            $data["origin"] = $origin;
            $data["destination"] = $destination;
            $data["weight"] = $weight;
            $data["dimension"] = $dimension;
            $data["status"] = "success";
            $data["quotations"] = json_decode($request);
        }
    }
}
if (isset($_POST["adminremoveassigneddoctor"])) {
    $doctorid = cleanInput($_POST["adminremoveassigneddoctor"]);
    $pharmaid = cleanInput($_POST["pharmaid"]);
    $sqlx = "UPDATE users SET assigneddoctor='0' WHERE id='$pharmaid'";
    if ($db->query($sqlx) === TRUE) {
        $data["status"] = "succesfull";
        $data["message"] = "The doctor has been removed for this pharmacy";
    } else {
        $row["status"] = "fail";
        $row["message"] = "Fail to update. Please try again";
        $data = $row;
    }
}

if (isset($_POST["adminassigndoctor"])) {
    $docemail = cleanInput($_POST["adminassigndoctor"]);
    $pharmaid = cleanInput($_POST["pharmaid"]);
    $sql = "SELECT * FROM users WHERE email='$docemail'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $docid = $row["id"];
        $sqlx = "UPDATE users SET assigneddoctor='$docid' WHERE id='$pharmaid'";
        if ($db->query($sqlx) === TRUE) {
            $data["status"] = "succesfull";
            $data["message"] = "The doctor has been assigned to this pharmacy";
            $data["docid"] = $docid;
            $data["docname"] = $row["fullname"];
        } else {
            $row["status"] = "fail";
            $row["message"] = "Fail to update. Please try again";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Doctor not found";
        $data = $row;
    }
}
if (isset($_POST["setselfpickupfinish"])) {
    $storeorderid = cleanInput($_POST["setselfpickupfinish"]);
    $sql = "SELECT * FROM job_order WHERE id='$storeorderid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rid = $row["restaurant_id"];
        $customerid = $row["owner"];
        $cart_price = $row["cart_price"];
        $sqld = "UPDATE job_order SET order_status='Completed' WHERE id='$storeorderid'";
        if ($db->query($sqld) === TRUE) {
            $sqlx = "UPDATE users SET wallet=wallet+'$cart_price' WHERE id='$rid'";
            if ($db->query($sqlx) === TRUE) {
                $row["status"] = "successfull";
                $row["message"] = "Update order status";
                $data = $row;
                insertTransaction($patientid, $rid, $serviceproviderrate, "Tele consultation fee");
                //sendNotification($spid, 'Payment received', 'You have recieved RM'.$cart_price.'. Please check your wallet.');
                $sqlx = "UPDATE users SET wallet=wallet-'$cart_price' WHERE id='$customerid'";
                if ($db->query($sqlx) === TRUE) {
                    $row["status"] = "successfull";
                    $row["message"] = "Update order status";
                    $data = $row;
                    insertTransaction($patientid, $rid, $serviceproviderrate, "Purchase");
                    //sendNotification($spid, 'Payment received', 'You have recieved RM'.$cart_price.'. Please check your wallet.');
                } else {
                    $row["status"] = "fail";
                    $row["message"] = "Fail to update order";
                    $data = $row;
                }
            } else {
                $row["status"] = "fail";
                $row["message"] = "Fail to update order";
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Fail to update order";
            $data = $row;
        }
    }
}
function activePharmamembership($id)
{
    global $db;
    $pid = $id;
    $sql = "SELECT * FROM pharmacymemberships WHERE owner='$pid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $today = date("Y-m-d");
        $expire = $row["expire"];
        $today_time = strtotime($today);
        $expire_time = strtotime($expire);
        if ($expire_time < $today_time) {
            return 'inactive';
        } else {
            return $row;
        }
    } else {
        return 'inactive';

    }
}

if (isset($_POST["subuserto"])) {
    $planid = cleanInput($_POST["subuserto"]);
    $userid = cleanInput($_POST["uid"]);
    $newDate = date('Y-m-d', strtotime('+1 month'));
    $planprice = 0;
    if ($planid == 1) {
        $psession = 1;
        $prescount = 1;
        $planprice = 1;
    } elseif ($planid == 2) {
        $psession = 50;
        $prescount = 50;
        $planprice = 259;
    } elseif ($planid == 3) {
        $psession = 100;
        $prescount = 100;
        $planprice = 399;
    } elseif ($planid == 4) {
        $psession = 200;
        $prescount = 200;
        $planprice = 699;
    } elseif ($planid == 5) {
        $psession = 500;
        $prescount = 500;
        $planprice = 1199;
    }
    if ($psession > 0) {
        $sql = "SELECT * FROM  pharmacymemberships WHERE owner='$userid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $today = date("Y-m-d");
            $expire = $row["expire"];

            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time < $today_time) {

            } else {

            }
            if ($planid > 2) {
                $sql = "UPDATE pharmacymemberships SET expire='$newDate', prescount=prescount +'$prescount', session=session +'$psession', membershiptype='$planid' WHERE owner='$userid'";
            } else {
                $sql = "UPDATE pharmacymemberships SET expire='$newDate', prescount='$prescount', session='$psession',  membershiptype='$planid' WHERE owner='$userid'";
            }

            if ($db->query($sql) === TRUE) {
                $sql = "UPDATE users SET wallet=wallet-'$planprice' WHERE id='$userid'";
                if ($db->query($sql) === TRUE) {
                    $row["status"] = "successfull";
                    $row["message"] = "Plan updated";
                    $data = $row;
                } else {
                    $row["status"] = "fail";
                    $row["message"] = "Server error. Please try again";
                    $data = $row;
                }

            } else {
                $row["status"] = "successfull";
                $row["message"] = "Database is empty";
                $data = $row;
            }
        } else {
            $sql = "INSERT INTO pharmacymemberships (expire, membershiptype, owner, prescount, session)
			VALUES ('$newDate', '$planid', '$userid', '$prescount', '$psession')";

            if ($db->query($sql) === TRUE) {
                $row["status"] = "successfull";
                $row["message"] = "Database is empty";
                $data = $row;
            } else {
                $row["status"] = "fail";
                $row["message"] = "Database is empty";
                $data = $row;
            }
        }

    } else {
        $row["status"] = "fail";
        $row["message"] = "Please select type of plan";
        $data = $row;
    }
}
if (isset($_POST["getpharmamembership"])) {
    $mem = cleanInput($_POST["getpharmamembership"]);
    $sql = "SELECT * FROM users WHERE id = '$mem'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["password"] = "***********";

        $sqlmem = "SELECT * FROM pharmacymemberships WHERE owner='$mem'";
        $resultmem = $db->query($sqlmem);
        if ($resultmem->num_rows > 0) {
            $rowmem = $resultmem->fetch_assoc();
            $today = date("Y-m-d");
            $expire = $rowmem["expire"];
            $today_time = strtotime($today);
            $expire_time = strtotime($expire);

            if ($expire_time < $today_time) {
                $rowmem["render_expire"] = 'Expired';
            } else {
                $rowmem["render_expire"] = 'Active';
            }
        } else {
            $rowmem = null;
        }


        $row["membership_data"] = $rowmem;
        $data = $row;

    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["riderUploadfile"])) {
    $id = cleanInput($authUser["id"]);
    $rider_ic = cleanInput($_POST["ic"]);
    $rider_lisence = cleanInput($_POST["lisence"]);
    if (strpos($rider_ic, 'http') !== false) {

    } else {
        define('UPLOAD_DIR', 'assets/');
        $img1 = $_POST["ic"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        $data1 = base64_decode($img1);

        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $rider_ic = $itemurl . $imgfile1;
    }

    if (strpos($rider_lisence, 'http') !== false) {

    } else {
        $img2 = $_POST["lisence"];
        if (strpos($img2, 'data:image/png;base64,') !== false) {
            $imgtype2 = ".png";
            $img2 = str_replace('data:image/png;base64,', '', $img2);
            $img2 = str_replace(' ', '+', $img2);
        }
        if (strpos($img2, 'data:image/jpeg;base64,') !== false) {
            $imgtype2 = ".jpg";
            $img2 = str_replace('data:image/jpeg;base64,', '', $img2);
            $img2 = str_replace(' ', '+', $img2);
        }
        $data2 = base64_decode($img2);
        $namez2 = rand(100000, 100000000) . uniqid();
        $namez2 = md5($namez2);
        $imgfile2 = UPLOAD_DIR . uniqid() . $namez2 . $imgtype2;
        $success2 = file_put_contents($imgfile2, $data2);
        $rider_lisence = $itemurl . $imgfile2;
    }

    $rider_activationssql = "SELECT * FROM rider_activations WHERE requester='$id'";
    $rider_activationsresult = $db->query($rider_activationssql);
    if ($rider_activationsresult->num_rows > 0) {
        $row = $rider_activationsresult->fetch_assoc();
        $rider_activationsdata = $row;
        $requester = $id;
        $rid = $rider_activationsdata["id"];
        $status = "Waiting";
        $sql = "UPDATE rider_activations SET rider_ic='$rider_ic', rider_lisence='$rider_lisence', status='$status' WHERE  id='$rid' ";

        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "updated";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }

    } else {
        $stats = "Waiting";
        $requester = $id;
        $rider_activationssql = "INSERT INTO rider_activations(rider_ic, rider_lisence, requester, status)
		VALUES ('$rider_ic', '$rider_lisence', '$requester', '$stats')";

        if ($db->query($rider_activationssql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "new";
            $row["message"] = "New record successfully created";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    }
}
if (isset($_POST["viewThisrideractivations"])) {
    $id = cleanInput($authUser["id"]);
    $rider_activationssql = "SELECT * FROM rider_activations WHERE requester='$id'";
    $rider_activationsresult = $db->query($rider_activationssql);
    if ($rider_activationsresult->num_rows > 0) {
        $row = $rider_activationsresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "new";
        $row["message"] = "You havent uploaded any verification file";
        $data = $row;
    }
}
if (isset($_POST["adminfindpharmacy"])) {
    $mem = cleanInput($authUser["adminfindpharmacy"]);
    $sql = "SELECT * FROM users WHERE email LIKE '%$mem%' AND provider_type='Pharmacist'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["getnearbypharmacist"])) {
    $sql = "SELECT * FROM users WHERE type='6' AND provider_type='Pharmacist' AND verified_service_provider='Approved'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pid = $row["id"];
            $sqlchek = "SELECT * FROM pharmacymemberships WHERE owner='$pid'";
            $resultcheck = $db->query($sqlchek);
            if ($resultcheck->num_rows > 0) {
                $check = $resultcheck->fetch_assoc();
                $row["distance"] = getDistance($row["lat"], $row["lng"], cleanInput($_POST["lat"]), cleanInput($_POST["lng"]), "K");
                $today = date("Y-m-d H:i:s");
                $startdate = $check["expire"];
                $offset = strtotime("+1 day");
                $enddate = date($startdate, $offset);
                $today_date = new DateTime($today);
                $expiry_date = new DateTime($enddate);
                if ($expiry_date > $today_date) {
                    $data[] = $row;
                }
            }
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["clearwalletuserbase"])) {
    $uid = cleanInput($_POST["clearwalletuserbase"]);
    $sql = "UPDATE users SET wallet='0' WHERE id='$uid'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Success";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["clearwalletrider"])) {
    $sql = "UPDATE users SET wallet='0' WHERE wallet > 0 AND type != 0 AND verified_service_provider ='Approved' AND provider_type = 'Pharmacist'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Success";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

if (isset($_POST["clearwalletpharmacy"])) {
    $sql = "UPDATE users SET wallet='0' WHERE wallet > 0 AND type != 0 AND verified_service_provider ='Approved' AND provider_type = 'Pharmacist'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Success";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

if (isset($_POST["adminupdatemastercategory"])) {
    $setting_value = cleanInput($_POST["adminupdatemastercategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='mastercategory'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["updateuserconid"])) {
    $id_token = cleanInput($_POST["updateuserconid"]);
    $uid = $authUser["id"];
    $sql = "UPDATE users SET id_token='$id_token' WHERE id='$uid' ";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["viewThiscaretele"])) {
    $id = cleanInput($_POST["viewThiscaretele"]);
    $caresql = "SELECT * FROM care WHERE id='$id'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }
}
if (isset($_POST["updateactivechatcare"])) {
    $chatid = $db->real_escape_string($_POST["updateactivechatcare"]);
    $lastid = $db->real_escape_string($_POST["lastid"]);
    $sql = "SELECT * FROM carechat WHERE chat_thread='$chatid' AND id > '$lastid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["chat_date"] = date("F j, Y, g:i a", strtotime($row["chat_date"]));
            $data[] = $row;
        }
    } else {
        $data["status"] = "empty";
        $data["message"] = "nothing new";
    }
}
if (isset($_POST["getcarechatcontent"])) {
    $id = $db->real_escape_string($_POST["getcarechatcontent"]);
    $sql = "SELECT * FROM carechat WHERE chat_thread='$id' ORDER BY id ASC";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["chat_date"] = date("F j, Y, g:i a", strtotime($row["chat_date"]));
            $data[] = $row;
        }
    } else {
        $data["status"] = "empty";
    }
}

if (isset($_POST["carepostchat"])) {
    $ownerid = $authUser["id"];
    $chatthread = $db->real_escape_string($_POST["conversationid"]);
    $chatmessage = $db->real_escape_string($_POST["message"]);
    $chatdate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO carechat (chat_thread, chat_content, owner, chat_date)
	VALUES ('$chatthread', '$chatmessage', '$ownerid', '$chatdate')";
    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Message sent successfully";
    } else {
        $data["status"] = "fail";
        $data["message"] = "Error: " . $sql . "<br>" . $db->error;
    }
}
if (isset($_POST["editcarepackage"])) {
    $to_id = cleanInput($_POST["editcarepackage"]);
    $packagedata = cleanInput($_POST["carepackageupdatedata"]);
    $packagedatadecoded = json_decode($packagedata);

    $sql = "UPDATE care SET packages_data='$packagedata' WHERE id='$to_id' ";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["getmyvaccinecert"])) {
    $owner = $authUser["id"];
    $sql = "SELECT * FROM care WHERE requesterid='$owner' AND require_attachment='true' AND request_status='Completed'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["inserttoreviews"])) {
    $ownerid = $authUser["id"];
    $from_id = $ownerid;
    $to_id = cleanInput($_POST["to_id"]);
    $rating = cleanInput($_POST["rating"]);
    $review = cleanInput($_POST["review"]);
    $job_type = cleanInput($_POST["job_type"]);
    $job_id = cleanInput($_POST["job_id"]);

    if ($from_id != "" && $to_id != "" && $rating != "" && $review != "" && $job_type != "" && $job_id != "") {
        $reviewssql = "INSERT INTO reviews (from_id, to_id, rating, review, job_type, job_id)
		VALUES ('$from_id', '$to_id', '$rating', '$review', '$job_type', '$job_id')";

        if ($db->query($reviewssql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "Your review has been submitted successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["viewnearestpharmacy"])) {
    $userssql = "SELECT * FROM users WHERE provider_type='Pharmacist' AND verified_service_provider='Approved'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        while ($row = $usersresult->fetch_assoc()) {
            $row["password"] = "******";
            if ($row["vendor_name"] == "Do not use") {

            } else {
                $pid = $row["id"];
                $pharmamembership = activePharmamembership($pid);
                if ($pharmamembership == "inactive") {

                } else {
                    if ($pharmamembership["session"] > 0 && $pharmamembership["prescount"] > 0) {
                        $row["membership_data"] = $pharmamembership;
                        $data[] = $row;
                    }

                }

            }

        }

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["viewselectedpharma"])) {
    $seletedp = cleanInput($_POST["viewselectedpharma"]);
    $userssql = "SELECT * FROM users WHERE id ='$seletedp'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        while ($row = $usersresult->fetch_assoc()) {
            $row["password"] = "******";
            if ($row["vendor_name"] == "Do not use") {

            } else {
                $pid = $row["id"];
                $pharmamembership = activePharmamembership($pid);
                if ($pharmamembership == "inactive") {

                } else {
                    $row["membership_data"] = $pharmamembership;
                    $data[] = $row;
                }

            }

        }

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["setproductstock"])) {
    $id = cleanInput($_POST["setproductstock"]);
    $available = cleanInput($_POST["newstockcount"]);
    $sql = "UPDATE products SET stock='$available' WHERE id='$id' ";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successful";
        $row["message"] = "This product stock has been updated";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["adminupdatepharmacategory"])) {
    $setting_value = cleanInput($_POST["adminupdatepharmacategory"]);
    $pharmaid = cleanInput($_POST["pid"]);
    $sql = "UPDATE users SET pharma_categories='$setting_value' WHERE  id='$pharmaid'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["submitspecialist_verification"])) {
    $specialties = cleanInput($_POST["specialties"]);
    $nsrid = cleanInput($_POST["nsrid"]);
    $nsrfile = processFile($_POST["nsrfile"]);
    $requester_id = $authUser["id"];
    $status = "Waiting for verification";

    if ($specialties != "" && $nsrid != "" && $nsrfile != "" && $requester_id != "" && $status != "") {
        $specialist_verificationsql = "INSERT INTO specialist_verification (request_date, specialties, nsrid, nsrfile, requester_id, status)
		VALUES ('$currentdatetime', '$specialties', '$nsrid', '$nsrfile', '$requester_id', '$status')";

        if ($db->query($specialist_verificationsql) === TRUE) {
            $row["status"] = "successful";
            $row["message"] = "Your verification request has been submitted succesfully";
            $data = $row;
        } else {
            $row["status"] = "fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["viewallspecialist_verification"])) {
    $rid = $authUser["id"];
    $sql = "SELECT * FROM specialist_verification WHERE requester_id='$rid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "You havent made any request to verify your speciality";
        $data = $row;
    }
}
if (isset($_POST["viewreviews"])) {
    $sid = cleanInput($_POST["viewreviews"]);
    $sql = "SELECT * FROM reviews WHERE to_id='$sid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $from = getProfile($row["from_id"]);
            $row["frominfo"] = $from;
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["viewWalkincenter"])) {
    $id = cleanInput($page_action_identifier);
    $settingssql = "SELECT * FROM settings WHERE setting_item='epinkcenter'";
    $settingsresult = $db->query($settingssql);
    if ($settingsresult->num_rows > 0) {
        $row = $settingsresult->fetch_assoc();
        $data = $row["setting_value"];

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Not found";
        $data = $row;
    }
}

if (isset($_POST["ensessionnotdoctor"])) {
    $id = cleanInput($_POST["ensessionnotdoctor"]);
    $clincalNote = cleanInput($_POST["clinicalNote"]);
    $referdata = cleanInput($_POST["refertonotdoctor"]);
    $spid = $authUser["id"];
    $chatssql = "SELECT * FROM chats WHERE id='$id' ";
    $chatsresult = $db->query($chatssql);
    if ($chatsresult->num_rows > 0) {
        $row = $chatsresult->fetch_assoc();
        if ($row["owner_one"] == $spid) {
            $patientid = $row["owner_two"];
        } else {
            $patientid = $row["owner_one"];
        }
        $serviceproviderrate = $row["doctorearning"];
        $sqlu = "UPDATE chats SET session_status='Ended', clincalNote='$clincalNote', referto='$referdata', paid='true', active='false' WHERE id='$id'";
        if ($db->query($sqlu) === TRUE) {
            $sqlsp = "UPDATE users SET wallet=wallet +'$serviceproviderrate' WHERE  id='$spid' ";
            $db->query($sqlsp);

            insertTransaction($patientid, $spid, $serviceproviderrate, "Tele consultation fee");
            sendNotification($spid, 'Payment received', 'You have recieved RM' . $serviceproviderrate . '. Please check your wallet.');
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "This session has been ended";
            $data = $row;
        } else {
            $row["card"] = "green";
            $row["status"] = "fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Dession not found";
        $data = $row;
    }
}

if (isset($_POST["initExistingVerification"])) {
    $oid = $authUser["id"];
    $accounts_verificationsql = "SELECT * FROM accounts_verification WHERE owner='$oid'";
    $accounts_verificationresult = $db->query($accounts_verificationsql);
    if ($accounts_verificationresult->num_rows > 0) {
        $row = $accounts_verificationresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "No existing verification_files";
        $data = $row;
    }
}
if (isset($_POST["uploadSelective"])) {
    $oid = $authUser["id"];
    $file = processFile($_POST["uploadSelective"]);
    $serverTarget = cleanInput($_POST["serverTarget"]);

    $accounts_verificationsql = "SELECT * FROM accounts_verification WHERE owner='$oid'";
    $accounts_verificationresult = $db->query($accounts_verificationsql);
    if ($accounts_verificationresult->num_rows > 0) {
        $row = $accounts_verificationresult->fetch_assoc();
        $accounts_verificationdata = $row;
        $sql = "UPDATE accounts_verification SET $serverTarget='$file' WHERE owner='$oid'";
        if ($db->query($sql) === TRUE) {
            $data["status_message"] = 'File uploaded succesfully';
            $data["status"] = 'successfull';
            $data["file"] = $file;
        } else {
            $data["status_message"] = 'Error uploading file' . $db->error;
            $data["status"] = 'fail';
        }
    } else {
        $sql = "INSERT INTO accounts_verification (owner, $serverTarget)
		VALUES ('$oid', '$file')";

        if ($db->query($sql) === TRUE) {
            $data["status_message"] = 'File uploaded succesfully';
            $data["status"] = 'successfull';
            $data["file"] = $file;
        } else {
            $data["status_message"] = 'Error uploading file - ' . $db->error;
            $data["status"] = 'fail';
        }
    }
}
if (isset($_POST["execeuserswallet"])) {
    $eusersid = cleanInput($authUser["id"]);
    $bank_account_number = cleanInput($_POST["eusersBank_account_number"]);
    $bank_name = cleanInput($_POST["eusersBank_name"]);


    if ($bank_account_number != "" && $bank_name != "") {

        $sql = "UPDATE users SET bank_account_number = '$bank_account_number',  bank_name = '$bank_name'  WHERE id='$eusersid'";
        if ($db->query($sql) === TRUE) {
            $data["status_message"] = 'Your submission has been submitted successfully.';
            $data["status"] = 'successfull';
        } else {
            $data["status_message"] = 'Error updating record';
            $data["status"] = 'fail';
        }

    } else {

        $data["status_message"] = 'Please all the form';
        $data["status"] = 'fail';
    }
}
if (isset($_POST["acceptthistelecare"])) {
    $id = cleanInput($_POST["acceptthistelecare"]);
    $caresql = "SELECT * FROM care WHERE id='$id'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $owner = $row["requesterid"];
        $chatwith = $authUser["id"];
        $price = '1.00';
        $sickness = $row["patientproblem"];
        $datetiembook = $row["caredate"];
        $bookingtype = "both";
        $sql = "SELECT * FROM chats WHERE owner_one='$owner' AND owner_two='$chatwith' AND active='true' AND archive='' OR owner_one='$chatwith' AND owner_two='$owner' AND active='true' AND AND archive=''";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data["status"] = "Successfull";
            $data["chat_id"] = $row["id"];
        } else {
            $sql = "INSERT INTO chats (owner_one, owner_two, active, session_reason, session_date, session_status, type, doctor)
			VALUES ('$owner', '$chatwith', 'true', '$sickness', '$datetiembook', 'new', '$bookingtype', 'true')";
            if ($db->query($sql) === TRUE) {
                $last_id = $db->insert_id;

                $sqlcharge = "UPDATE users SET wallet=wallet-$price WHERE id='$owner'";
                $db->query($sqlcharge);
                $sqlgive = "UPDATE users SET wallet=wallet+$price WHERE id='$chatwith'";
                $db->query($sqlgive);
                $chatdate = date("Y-m-d H:i:s");
                $reason = 'Patient have started a chat session. Reason: ' . $sickness;
                $sqlinsertchat = "INSERT INTO chatcontent (chat_thread, chat_content, owner, chat_date) VALUES ('$last_id', '$reason', '0', '$chatdate')";
                $db->query($sqlinsertchat);
                $sqlucare = "UPDATE care SET request_status='Completed', teleid='$last_id' WHERE id='$id'";
                $db->query($sqlucare);
                $data["status"] = "Successfull";
                $data["chat_id"] = $last_id;
                $data["partnerid"] = $owner;

            } else {
                $row["status"] = "fail";
                $row["message"] = "Error inserting record: " . $db->error;
                $data = $row;
            }
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }
}
if (isset($_POST["teleCareRequest"])) {
    $jid = cleanInput($_POST["teleCareRequest"]);

    $ecare_servicessql = "SELECT * FROM care WHERE id='$jid'";
    $ecare_servicesresult = $db->query($ecare_servicessql);
    if ($ecare_servicesresult->num_rows > 0) {
        $row = $ecare_servicesresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["adminupdateelabcategory"])) {
    $setting_value = cleanInput($_POST["adminupdateelabcategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='elabcategory'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

if (isset($_POST["adminupdatesubelabcategory"])) {
    $setting_value = cleanInput($_POST["adminupdatesubelabcategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='ecaresubcategory'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["adminupdateLabcategory"])) {
    $setting_value = cleanInput($_POST["adminupdateLabcategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='elabcategory'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["subadminupdatecarecategory"])) {
    $setting_value = cleanInput($_POST["subadminupdatecarecategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='ecaresubcategory' ";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["adminupdatecarecategory"])) {
    $setting_value = cleanInput($_POST["adminupdatecarecategory"]);
    $sql = "UPDATE settings SET setting_value='$setting_value' WHERE  setting_item='ecarecategory' ";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
/* if(isset($_POST["adminupdatecarecategory"])){

	$categories = cleanInput($_POST["adminupdatecarecategory"]);
	$type = cleanInput($_POST["type"]);
	$catname = cleanInput($_POST["nameavailable"]);
	if($type == "remove"){
		$sql = "SELECT * FROM products WHERE category='$catname' AND owner='$vendorid'";
		$result = $db->query($sql);
		if ($result->num_rows > 0) {
			$row["status"] = "fail";
			$row["message"] = "Please delete product under this category before proceeding.";
			$data = $row;
		} else {

			$sql = "UPDATE users SET categories='$categories' WHERE id='$vendorid'";
			if ($db->query($sql) === TRUE) {
				$row["status"] = "success";
				$row["message"] = "Category updated";
				$data = $row;
			} else {
				$row["status"] = "fail";
				$row["message"] = "Fail to update category";
				$data = $row;
			}
		}
	}else{
		$sql = "UPDATE users SET categories='$categories' WHERE id='$vendorid'";
		if ($db->query($sql) === TRUE) {
			$row["status"] = "success";
			$row["message"] = "Category updated";
			$data = $row;
		} else {
			$row["status"] = "fail";
			$row["message"] = "Fail to update category";
			$data = $row;
		}
	}
} */
if (isset($_POST["EditPharmaorganization"])) {
    $EditPharmaorganizationid = cleanInput($authUser["id"]);

    $sql = "SELECT vendor_name, vendor_address, vendor_open_time, vendor_close_time, organization_name, organization_address, organization_city, organization_state, organization_postcode, organization_country, organization_phone_number, organization_fax_number, organization_registeration_number  FROM users WHERE id='$EditPharmaorganizationid'";

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $eusers = $result->fetch_assoc();
        $eusers["status"] = 'successfull';
        $eusers["status_message"] = 'You request has been processed successfully';
        $data = $eusers;
    } else {
        $data["status"] = 'fail';
        $data["status_message"] = 'Failed to process this request. Please try again or contact our support';
    }
}

if (isset($_POST["execEditPharmaorganization"])) {
    $EditPharmaorganizationid = cleanInput($authUser["id"]);
    $vendor_name = cleanInput($_POST["EditPharmaorganizationVendor_name"]);
    $vendor_address = cleanInput($_POST["EditPharmaorganizationVendor_address"]);
    $vendor_open_time = cleanInput($_POST["EditPharmaorganizationVendor_open_time"]);
    $vendor_close_time = cleanInput($_POST["EditPharmaorganizationVendor_close_time"]);
    $organization_name = cleanInput($_POST["EditPharmaorganizationOrganization_name"]);
    $organization_address = cleanInput($_POST["EditPharmaorganizationOrganization_address"]);
    $organization_city = cleanInput($_POST["EditPharmaorganizationOrganization_city"]);
    $organization_state = cleanInput($_POST["EditPharmaorganizationOrganization_state"]);
    $organization_postcode = cleanInput($_POST["EditPharmaorganizationOrganization_postcode"]);
    $organization_country = cleanInput($_POST["EditPharmaorganizationOrganization_country"]);
    $organization_phone_number = cleanInput($_POST["EditPharmaorganizationOrganization_phone_number"]);
    $organization_fax_number = cleanInput($_POST["EditPharmaorganizationOrganization_fax_number"]);
    $organization_registeration_number = cleanInput($_POST["EditPharmaorganizationOrganization_registeration_number"]);


    if ($vendor_name != "" && $vendor_address != "" && $vendor_open_time != "" && $vendor_close_time != "" && $organization_name != "" && $organization_address != "" && $organization_city != "" && $organization_state != "" && $organization_postcode != "" && $organization_country != "" && $organization_phone_number != "" && $organization_fax_number != "" && $organization_registeration_number != "") {

        $sql = "UPDATE users SET vendor_name = '$vendor_name',  vendor_address = '$vendor_address',  vendor_open_time = '$vendor_open_time',  vendor_close_time = '$vendor_close_time',  organization_name = '$organization_name',  organization_address = '$organization_address',  organization_city = '$organization_city',  organization_state = '$organization_state',  organization_postcode = '$organization_postcode',  organization_country = '$organization_country',  organization_phone_number = '$organization_phone_number',  organization_fax_number = '$organization_fax_number',  organization_registeration_number = '$organization_registeration_number'  WHERE id='$EditPharmaorganizationid'";
        if ($db->query($sql) === TRUE) {
            $data["status_message"] = 'Your submission has been submitted successfully.';
            $data["status"] = 'successfull';
        } else {
            $data["status_message"] = 'Error updating record';
            $data["status"] = 'fail';
        }

    } else {

        $data["status_message"] = 'Please all the form';
        $data["status"] = 'fail';
    }
}


if (isset($_POST["updatecategory"])) {
    $uid = $authUser["id"];
    $categories = cleanInput($_POST["updatecategory"]);
    $type = cleanInput($_POST["type"]);
    $catname = cleanInput($_POST["nameavailable"]);
    if ($type == "remove") {
        $sql = "SELECT * FROM products WHERE category='$catname' AND owner='$uid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row["status"] = "fail";
            $row["message"] = "Please delete product under this category before deleting this category.";
            $data = $row;

        } else {
            $sql = "UPDATE users SET pharma_categories='$categories' WHERE id='$uid'";
            if ($db->query($sql) === TRUE) {
                $row["status"] = "success";
                $row["message"] = "Category updated";
                $data = $row;
            } else {
                $row["status"] = "fail";
                $row["message"] = "Fail to update category";
                $data = $row;
            }
        }
    } else {
        $sql = "UPDATE users SET pharma_categories='$categories' WHERE id='$uid'";
        if ($db->query($sql) === TRUE) {
            $row["status"] = "success";
            $row["message"] = "Category updated";
            $data = $row;
        } else {
            $row["status"] = "fail";
            $row["message"] = "Fail to update category";
            $data = $row;
        }
    }
}
if (isset($_POST["inithr"])) {
    $requester_id = $authUser["id"];
    $sql = "SELECT company_name FROM users WHERE id='$requester_id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["linkhr"])) {
    $requester_id = $authUser["id"];
    $linkhr = cleanInput($_POST["linkhr"]);
    $sql = "SELECT * FROM users WHERE company_code='$linkhr' AND company_manager='true'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $companyname = $row["company_name"];
        $sql = "UPDATE users SET company_name='$companyname', company_manager='false' WHERE id='$requester_id'";
        if ($db->query($sql) === TRUE) {
            $row["status"] = "success";
            $row["message"] = "Accoount linked";
            $data = $row;
        } else {
            $row["status"] = "fail";
            $row["message"] = "Database is empty";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["unlinkhr"])) {
    $requester_id = $authUser["id"];
    $sql = "UPDATE users SET company_name='' WHERE id='$requester_id' AND company_manager='false'";

    if ($db->query($sql) === TRUE) {
        $row["status"] = "success";
        $row["message"] = "Accoount unlinked";
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["reverifyimagebase64"])) {
    $requester_id = $authUser["id"];
    define('UPLOAD_DIR', 'assets/');
    $img1 = $_POST["reverifyimagebase64"];
    if (strpos($img1, 'data:image/png;base64,') !== false) {
        $imgtype1 = ".png";
        $img1 = str_replace('data:image/png;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
        $imgtype1 = ".jpg";
        $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    $data1 = base64_decode($img1);
    $namez = rand(100000, 100000000) . uniqid();
    $namez = md5($namez);
    $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
    $success1 = file_put_contents($imgfile1, $data1);
    $imgfileurl1 = $itemurl . $imgfile1;
    $sql = "UPDATE users SET ic='$imgfileurl1'  WHERE  id='$requester_id'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "You re verfiy request has been recieved. It will take 24 - 48 hour to process. Come back later";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["viewThisepinkswab"])) {
    $id = cleanInput($_POST["viewThisepinkswab"]);
    $epinkswabsql = "SELECT * FROM epinkswab WHERE id='$id'";
    $epinkswabresult = $db->query($epinkswabsql);
    if ($epinkswabresult->num_rows > 0) {
        $row = $epinkswabresult->fetch_assoc();
        $row["lat"] = '3.0738';
        $row["lng"] = '101.5183';
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }
}
if (isset($_POST["viewallepinkswab"])) {
    $requester_id = $authUser["id"];
    $sql = "SELECT * FROM epinkswab WHERE requester_id='$requester_id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["inserttoepinkswab"])) {
    $requester_id = $authUser["id"];
    $kit_name = cleanInput($_POST["kit_name"]);
    $address = cleanInput($_POST["address"]);
    $delivery_price = cleanInput($_POST["delivery_price"]);
    $total_price = cleanInput($_POST["total_price"]);
    $kit_price = cleanInput($_POST["kit_price"]);

    if ($requester_id != "" && $kit_name != "" && $address != "" && $delivery_price != "" && $total_price != "" && $kit_price != "") {
        $epinkswabsql = "INSERT INTO epinkswab (requester_id, kit_name, address, delivery_price, total_price, kit_price, videofile, status, doctor_id, test_result)
		VALUES ('$requester_id', '$kit_name', '$address', '$delivery_price', '$total_price', '$kit_price', 'Not Set', 'Delivering Kit', '0', 'Waiting')";

        if ($db->query($epinkswabsql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "Your request has been received";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["adminupdatecategory"])) {
    $vendorid = cleanInput($_POST["vendorid"]);
    $categories = cleanInput($_POST["adminupdatecategory"]);
    $type = cleanInput($_POST["type"]);
    $catname = cleanInput($_POST["nameavailable"]);
    if ($type == "remove") {
        $sql = "SELECT * FROM products WHERE category='$catname' AND owner='$vendorid'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row["status"] = "fail";
            $row["message"] = "Please delete product under this category before proceeding.";
            $data = $row;
        } else {

            $sql = "UPDATE users SET categories='$categories' WHERE id='$vendorid'";
            if ($db->query($sql) === TRUE) {
                $row["status"] = "success";
                $row["message"] = "Category updated";
                $data = $row;
            } else {
                $row["status"] = "fail";
                $row["message"] = "Fail to update category";
                $data = $row;
            }
        }
    } else {
        $sql = "UPDATE users SET categories='$categories' WHERE id='$vendorid'";
        if ($db->query($sql) === TRUE) {
            $row["status"] = "success";
            $row["message"] = "Category updated";
            $data = $row;
        } else {
            $row["status"] = "fail";
            $row["message"] = "Fail to update category";
            $data = $row;
        }
    }
}
if (isset($_POST["getdeliveryprice"])) {
    $from = cleanInput($_POST["from"]);
    $fromlat = cleanInput($_POST["fromlat"]);
    $fromlng = cleanInput($_POST["fromlng"]);
    $to = cleanInput($_POST["to"]);
    $toLat = cleanInput($_POST["tolat"]);
    $toLng = cleanInput($_POST["tolng"]);
    $unitz = "KM";
    $distance = getDistance($fromlat, $fromlng, $toLat, $toLng, $unitz);
    $data["speedy"] = getPrice($from, $to);
    $data["distance"] = $distance;

}
if (isset($_POST["update_account_runner"])) {
    $ownerid = $authUser["id"];
    $firstname = $db->real_escape_string($_POST["rider_update_firstname"]);
    $lastname = $db->real_escape_string($_POST["rider_update_lastname"]);
    $phonenumber = $db->real_escape_string($_POST["rider_update_phonenumber"]);
    $rider_profile_picture_update = $db->real_escape_string($_POST["rider_profile_picture_update"]);

    if ($rider_profile_picture_update == "") {
        $pp = $authUser["profile_img"];
    } else {
        define('UPLOAD_DIR', 'profile_image/');
        $img1 = $_POST["rider_profile_picture_update"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        $data1 = base64_decode($img1);
        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $pp = $itemurl . $imgfile1;

    }

    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', profile_img='$pp'  WHERE id='$ownerid'";

    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Account updated successfully";
        $data["firstname"] = $firstname;
        $data["lastname"] = $lastname;
        $data["date"] = $dob;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Please try again later";
    }
}
if (isset($_POST["getcallerprofile"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["getcallerprofile"]);
    $data = getsimpleProfiletoken($id);

}
if (isset($_POST["deleteFromproducts"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["deleteFromproducts"]);
    $sql = "DELETE FROM products WHERE id='$id' AND owner='$owner'";
    if ($db->query($sql) === TRUE) {
        $row["status"] = "success";
        $row["message"] = 'The menu has been deleted successfully';
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Error deleting record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["updatemenu"])) {
    $uid = $authUser["id"];
    $id = cleanInput($_POST["updatemenu"]);
    $name = cleanInput($_POST["product_name"]);
    $description = cleanInput($_POST["product_description"]);
    $price = cleanInput($_POST["vappyprice"]);
    $originalprice = cleanInput($_POST["originalprice"]);
    $quanitity = cleanInput($_POST["quanitity"]);
    if ($id != "" && $name != "" && $description != "" && $price != "") {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', originalprice='$originalprice', stock='$quanitity' WHERE  id='$id' AND owner='$uid'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Success";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["riderpickedup"])) {

    $id = cleanInput($_POST["riderpickedup"]);
    $type = cleanInput($_POST["type"]);
    if ($type == "store") {
        $sql = "UPDATE job_order SET order_status='Delivering' WHERE  id='$id' ";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $sql = "UPDATE chats SET delivery_completed='Delivering' WHERE  id='$id' ";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    }
}

if (isset($_POST["ridercomplete"])) {
    $riderid = $authUser["id"];
    $id = cleanInput($_POST["ridercomplete"]);
    $type = cleanInput($_POST["type"]);
    if ($type == "store") {
        $job_ordersql = "SELECT * FROM job_order WHERE id='$id' AND order_status='Delivering'";
        $job_orderresult = $db->query($job_ordersql);
        if ($job_orderresult->num_rows > 0) {
            $row = $job_orderresult->fetch_assoc();
            $topayrider = $row["delivery_price"];
            $topaypharma = $row["restaurant_profit"];
            $paidby = $row["owner"];
            $pharmaid = $row["restaurant_id"];
            $sql = "UPDATE job_order SET order_status='Completed' WHERE id='$id'";
            if ($db->query($sql) === TRUE) {
                //Update Rider Wallet
                $sqlx = "UPDATE users SET wallet=wallet+'$topayrider' WHERE  id='$riderid'";
                if ($db->query($sqlx) === TRUE) {
                    //Update Pharma Wallet
                    $sqly = "UPDATE users SET wallet=wallet+'$topaypharma' WHERE  id='$pharmaid'";
                    if ($db->query($sqly) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successfull";
                        $row["message"] = "The record has been updated successfully";
                        $data = $row;
                        //Insert transaction hitory for pharmacy
                        insertTransaction($paidby, $pharmaid, $topaypharma, 'Payment for medications');
                        //Insert transaction hitory for rider
                        insertTransaction($paidby, $riderid, $topayrider, 'Payment for delivery');
                        $usedpayment = $topaypharma + $topayrider;
                        $totalpayment = $row["cart_price"];
                        $topaysystem = $row["cart_price"] - $usedpayment;
                        //Insert transaction hitory for system
                        insertTransaction($paidby, 0, $topaysystem, 'Store Purchase ID -' . $id);
                        $sqlz = "UPDATE users SET wallet=wallet-'$totalpayment' WHERE  id='$paidby'";
                        $db->query($sqlz);
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error updating record: " . $db->error;
                        $data = $row;
                    }

                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }

        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Not Found";
            $data = $row;
        }
    } else {
        $sql = "SELECT * FROM chats WHERE id='$id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $delifee = $row["delivery_fee"];
            $paidby = $row["owner_one"];
            $pharmaid = $row["storeid"];
            $sql = "UPDATE chats SET delivery_completed='Completed' WHERE  id='$id' ";
            if ($db->query($sql) === TRUE) {
                $sqlx = "UPDATE users SET wallet=wallet+'$delifee' WHERE  id='$riderid'";
                if ($db->query($sqlx) === TRUE) {
                    insertTransaction($paidby, $riderid, $delifee, 'Payment for delivery');
                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    $row["message"] = "The record has been updated successfully";
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }

    }
}
if (isset($_POST["acceptriderjob"])) {
    $id = cleanInput($_POST["acceptriderjob"]);
    $type = cleanInput($_POST["type"]);

    if ($type == "store") {
        $rid = $authUser["id"];
        $sql = "UPDATE job_order SET runner='$rid', order_status='Accepted' WHERE id='$id'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "You have accepted this job";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $rid = $authUser["id"];
        $sql = "UPDATE chats SET runnedid='$rid', delivery_completed='Accepted' WHERE id='$id'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "You have accepted this job";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    }

}
if (isset($_POST["viewriderjobStore"])) {
    $jobid = cleanInput($_POST["viewriderjobStore"]);
    $job_ordersql = "SELECT * FROM job_order WHERE id='$jobid'";
    $job_orderresult = $db->query($job_ordersql);
    if ($job_orderresult->num_rows > 0) {
        $row = $job_orderresult->fetch_assoc();
        $row["vendor_information"] = getVendorprofile($row["restaurant_id"]);
        $row["patient_profile"] = getsimpleProfile($row["owner"]);
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["viewriderjob"])) {
    $jobid = cleanInput($_POST["viewriderjob"]);
    $sql = "SELECT * FROM chats WHERE id='$jobid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $today_date = new DateTime($today);
        $owneroneisdoctor = checkDoc($row["owner_one"]);
        if ($owneroneisdoctor == true) {
            $row["patient_id"] = $row["owner_two"];
            $row["patient_profile"] = getsimpleProfile($row["owner_two"]);
            $row["doctor_id"] = $row["owner_one"];
            $row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
        } else {
            $row["patient_id"] = $row["owner_one"];
            $row["patient_profile"] = getsimpleProfile($row["owner_one"]);
            $row["doctor_id"] = $row["owner_two"];
            $row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
        }
        $request_date = new DateTime($row["caredate"]);
        if ($request_date < $today_date) {
            $row["expired"] = true;
        } else {
            $row["expired"] = false;
        }
        $row["price"] = 120.00;
        $timestamp = $row["caredate"] . " " . $row["caretime"];
        $row["timestamp"] = $timestamp;
        $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
        $date1 = $timestamp;
        $date2 = $currentdatetime;
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);
        $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
        $row["vendor_information"] = getVendorprofile($row["storeid"]);
        $data = $row;

    } else {
        $row["status"] = "fail";
        $row["message"] = "Not found";
    }
}
if (isset($_POST["riderjob"])) {
    $available;
    $inprogress;
    $runnerid = $authUser["id"];
    $sql = "SELECT * FROM chats WHERE delivery_completed ='Ready for pickup' AND delivery_type != 'Pickup'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["caredate"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["caredate"] . " " . $row["caretime"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $row["vendor_information"] = getVendorprofile($row["storeid"]);
            $row["type"] = 'Teleconsultation';
            $available[] = $row;
        }
    } else {

    }

    $sql = "SELECT * FROM job_order WHERE order_status='Ready for pickup'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["order_date"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["order_date"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $row["vendor_information"] = getVendorprofile($row["restaurant_id"]);
            $row["type"] = 'Store Purchase';
            $available[] = $row;
        }
    }

    $sql = "SELECT * FROM chats WHERE runnedid='$runnerid' AND delivery_completed != 'Completed'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["caredate"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["caredate"] . " " . $row["caretime"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $row["vendor_information"] = getVendorprofile($row["storeid"]);
            $inprogress[] = $row;
        }
    } else {

    }
    $sql = "SELECT * FROM job_order WHERE order_status='Accepted'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["order_date"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["order_date"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $row["vendor_information"] = getVendorprofile($row["restaurant_id"]);
            $row["type"] = 'Store Purchase';
            $inprogress[] = $row;
        }
    }
    $sql = "SELECT * FROM job_order WHERE order_status='Delivering'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["order_date"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["order_date"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $row["vendor_information"] = getVendorprofile($row["restaurant_id"]);
            $row["type"] = 'Store Purchase';
            $inprogress[] = $row;
        }
    }
    $data["available"] = $available;
    $data["inprogress"] = $inprogress;

}
if (isset($_POST["setPrepared"])) {
    $id = cleanInput($_POST["setPrepared"]);
    $type = cleanInput($_POST["type"]);
    if ($type == "pharma") {
        $chatssql = "SELECT * FROM chats WHERE id='$id'";
        $chatsresult = $db->query($chatssql);
        if ($chatsresult->num_rows > 0) {
            $row = $chatsresult->fetch_assoc();
            $owneroneisdoctor = checkDoc($row["owner_one"]);
            if ($owneroneisdoctor == true) {
                $row["patient_id"] = $row["owner_two"];
                $row["patient_profile"] = getsimpleProfile($row["owner_two"]);
                $row["doctor_id"] = $row["owner_one"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
            } else {
                $row["patient_id"] = $row["owner_one"];
                $row["patient_profile"] = getsimpleProfile($row["owner_one"]);
                $row["doctor_id"] = $row["owner_two"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
            }
            $vendorprofile = getVendorprofile($row["storeid"]);
            $make = requestSpeedy($patientprofile, $customerphonenumber, $customeraddress, $restaurantname, $restaurantphonenumber, $restaurantaddress, $orderid);
            $patient = $row["patient_profile"];

            $row["patient_full_name"] = $patient["full_name"];
            $row["patient_phone_number"] = $patient["phonenumber"];
            $row["patient_delivery_address"] = $row["delivery_address"];
            $make = json_decode(requestSpeedy($row["patient_full_name"], $row["patient_phone_number"], $row["patient_delivery_address"], $vendorprofile["vendor_name"], $vendorprofile["phonenumber"], $vendorprofile["vendor_address"], '$id'));
            if ($make->is_successful == true) {
                $sql = "UPDATE chats SET delivery_completed='3rd Party', storeapprove='true' WHERE  id='$id' ";
                if ($db->query($sql) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    $row["message"] = "The record has been updated successfully";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $sql = "UPDATE chats SET delivery_completed='Ready for pickup', storeapprove='true' WHERE  id='$id' ";

                if ($db->query($sql) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    $row["message"] = "The record has been updated successfully";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            }

            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
            $data = $row;
        }
    } else {
        $sql = "SELECT * FROM job_order WHERE id='$id'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $vendorprofile = getVendorprofile($row["restaurant_id"]);
            $row["patient_profile"] = getsimpleProfile($row["owner"]);
            $patient = $row["patient_profile"];
            $orderdata = json_decode($row["data"]);
            $patient["patient_delivery_address"] = $orderdata->delivery_address;
            $borzostatus = "Off";
            if ($borzostatus == "Off") {
                $sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE  id='$id' ";
                if ($db->query($sql) === TRUE) {


                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    if ($row["deliverytype"] == "pickup") {
                        $row["message"] = "Ready for customer pick up";
                    } else {
                        $row["message"] = "Looking for rider";
                    }

                    $row["speedy"] = $make;
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $make = json_decode(requestSpeedy($patient["full_name"], $patient["phonenumber"], $patient["patient_delivery_address"], $vendorprofile["vendor_name"], $vendorprofile["phonenumber"], $vendorprofile["vendor_address"], '$id'));


                if ($make->is_successful == true) {
                    $row["speedyinfo"] = $make;
                    $speedyorderid = $make->order->order_id;
                    $sql = "UPDATE job_order SET order_status='3rd Party', speedy_order_id='$speedyorderid' WHERE id='$id'";
                    if ($db->query($sql) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successfull";
                        $row["message"] = "The record has been updated successfully";
                        $data = $row;
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error updating record: " . $db->error;
                        $data = $row;
                    }
                } else {
                    $sql = "UPDATE job_order SET order_status='Ready for pickup' WHERE  id='$id' ";

                    if ($db->query($sql) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successfull";
                        $row["message"] = "Looking for rider - ";
                        $row["speedy"] = $make;
                        $data = $row;
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error updating record: " . $db->error;
                        $data = $row;
                    }
                }
            }

        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Order not found";
            $data = $row;
        }

    }


}

if (isset($_POST["pharmaorder"])) {
    $vendorid = $authUser["id"];
    $sql = "SELECT * FROM chats WHERE storeid='$vendorid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $owneroneisdoctor = checkDoc($row["owner_one"]);
            if ($owneroneisdoctor == true) {
                $row["patient_id"] = $row["owner_two"];
                $row["patient_profile"] = getsimpleProfile($row["owner_two"]);
                $row["doctor_id"] = $row["owner_one"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
            } else {
                $row["patient_id"] = $row["owner_one"];
                $row["patient_profile"] = getsimpleProfile($row["owner_one"]);
                $row["doctor_id"] = $row["owner_two"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
            }
            if ($row["paid"] == "true") {
                $pharmapurchase[] = $row;
            }
        }
    } else {
        $rowc["status"] = "fail";
        $rowc["message"] = "Database is empty";
        $pharmapurchase = $row;
    }
    $sql = "SELECT * FROM job_order WHERE restaurant_id='$vendorid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($rows = $result->fetch_assoc()) {

            $rows["patient_id"] = $rows["owner"];
            $rows["patient_profile"] = getsimpleProfile($rows["owner"]);
            $storepurchase[] = $rows;
        }
    } else {
        $rowf["status"] = "fail";
        $rowf["message"] = "Database is empty";
        $storepurchase = null;
    }
    $data["store"] = $storepurchase;
    $data["pharma"] = $pharmapurchase;

}

if (isset($_POST["pharmaorderview"])) {
    $orderid = cleanInput($_POST["pharmaorderview"]);
    $type = cleanInput($_POST["type"]);
    if ($type == "store") {
        $sql = "SELECT * FROM job_order WHERE id='$orderid'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row["patient_id"] = $row["owner_two"];
            $row["type"] = "store";
            $row["patient_profile"] = getsimpleProfile($row["owner"]);
            $data = $row;

        } else {
            $row["status"] = "fail";
            $row["message"] = "Database is empty";
            $data = $row;
        }
    } elseif ($type == "pharma") {
        $sql = "SELECT * FROM chats WHERE id='$orderid'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $row["type"] = "pharma";
            $owneroneisdoctor = checkDoc($row["owner_one"]);
            if ($owneroneisdoctor == true) {
                $row["patient_id"] = $row["owner_two"];
                $row["patient_profile"] = getsimpleProfile($row["owner_two"]);
                $row["doctor_id"] = $row["owner_one"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_one"]);
            } else {
                $row["patient_id"] = $row["owner_one"];
                $row["patient_profile"] = getsimpleProfile($row["owner_one"]);
                $row["doctor_id"] = $row["owner_two"];
                $row["doctor_profile"] = getsimpleProfile($row["owner_two"]);
            }
            $data = $row;

        } else {
            $row["status"] = "fail";
            $row["message"] = "Database is empty";
            $data = $row;
        }
    }
}

if (isset($_POST["spwalletsetting"])) {
    $sp_id = $authUser["id"];
    $userssql = "SELECT bank_name, bank_account_number FROM users WHERE id='$sp_id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row = $usersresult->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Not found";
        $data = $row;
    }
}

if (isset($_POST["docfinalsetup"])) {
    $sp_id = $authUser["id"];
    if ($_POST["signature"] != "") {
        define('UPLOAD_DIR', 'signatures/');
        $img1 = $_POST["signature"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        $data1 = base64_decode($img1);
        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $signaturefile = $itemurl . $imgfile1;
        $docfinalsetup = cleanInput($_POST["docfinalsetup"]);
        $sql = "UPDATE users SET signaturefile='$signaturefile', trustgatepin='$docfinalsetup'  WHERE  id='$sp_id'";
    } else {
        $docfinalsetup = cleanInput($_POST["docfinalsetup"]);
        $sql = "UPDATE users SET trustgatepin='$docfinalsetup' WHERE id='$sp_id'";
    }

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }

}
function pdfToBase64($url)
{
    $pdf = file_get_contents($url);
    $pdfbase64 = base64_encode($pdf);
    return $pdfbase64;
}

function imgToBase64($url)
{
    $png = file_get_contents($url);
    $pngbase64 = base64_encode($png);
    return $pngbase64;
}


if (isset($_POST["updatedoctorsignature"])) {
    $sp_id = $authUser["id"];
    define('UPLOAD_DIR', 'signatures/');
    if ($_POST["updatedoctorsignature"] == "") {
        $signaturefile = $authUser["signaturefile"];
    } else {
        $img1 = $_POST["updatedoctorsignature"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        $data1 = base64_decode($img1);
        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $signaturefile = $itemurl . $imgfile1;
        $sql = "UPDATE users SET signaturefile='$signaturefile'  WHERE  id='$sp_id'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    }
}
if (isset($_POST["updatespaccount"])) {
    define('UPLOAD_DIR', 'profile_image/');
    $sp_id = $authUser["id"];
    $firstname = cleanInput($_POST["firstname"]);
    $lastname = cleanInput($_POST["lastname"]);
    $aboutme = cleanInput($_POST["aboutme"]);
    $phonenumber = cleanInput($_POST["phonenumber"]);
    $icnumber = cleanInput($_POST["icnumber"]);
    $university = cleanInput($_POST["university"]);

    if ($_POST["profileimage"] == "") {
        $profileimage = $authUser["profile_img"];
    } else {
        $img1 = $_POST["profileimage"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        $data1 = base64_decode($img1);
        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $profileimage = $itemurl . $imgfile1;
    }
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', about_me='$aboutme', phonenumber='$phonenumber', ic_number='$icnumber', education='$university', profile_img='$profileimage'  WHERE  id='$sp_id'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

if (isset($_POST["editusersorganization"])) {
    $sp_id = $authUser["id"];
    $organization_name = cleanInput($_POST["editorganization_name"]);
    $organization_designation = cleanInput($_POST["editorganization_designation"]);
    $organization_address = cleanInput($_POST["editorganization_address"]);
    $organization_city = cleanInput($_POST["editorganization_city"]);
    $organization_state = cleanInput($_POST["editorganization_state"]);
    $organization_postcode = cleanInput($_POST["editorganization_postcode"]);
    $organization_country = cleanInput($_POST["editorganization_country"]);
    $organization_phone_number = cleanInput($_POST["editorganization_phone_number"]);
    $organization_fax_number = cleanInput($_POST["editorganization_fax_number"]);
    $organization_registeration_number = cleanInput($_POST["editorganization_registeration_number"]);
    $sql = "UPDATE users SET organization_name='$organization_name', organization_designation='$organization_designation', organization_address='$organization_address', organization_city='$organization_city', organization_state='$organization_state', organization_postcode='$organization_postcode', organization_country='$organization_country', organization_phone_number='$organization_phone_number', organization_fax_number='$organization_fax_number', organization_registeration_number='$organization_registeration_number' WHERE  id='$sp_id'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["sporganization"])) {
    $sp_id = $authUser["id"];
    $userssql = "SELECT * FROM users WHERE id='$sp_id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row = $usersresult->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Not found";
        $data = $row;
    }
}
if (isset($_POST["spaccount"])) {
    $sp_id = $authUser["id"];
    $userssql = "SELECT * FROM users WHERE id='$sp_id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row = $usersresult->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Not found";
        $data = $row;
    }
}
if (isset($_POST["completecarejobcert"])) {
    $sp_id = $authUser["id"];
    $spacceptjob = cleanInput($_POST["completecarejobcert"]);
    $attachments = cleanInput($_POST["certificatedata"]);

    $caresql = "SELECT * FROM care WHERE id='$spacceptjob'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $caredata = $row;
        $sql = "UPDATE care SET request_status='Completed', sp_id='$sp_id', attachments='$attachments' WHERE id='$spacceptjob'";
        if ($db->query($sql) === TRUE) {

            $from_user = cleanInput($caredata["requesterid"]);
            $to_user = cleanInput($sp_id);
            $amount = cleanInput($caredata["careprice"]);
            $transaction_date = $currentdatetime;
            $sql = "UPDATE users SET wallet=wallet-'$amount' WHERE  id='$from_user' ";

            if ($db->query($sql) === TRUE) {
                $sql = "UPDATE users SET wallet=wallet+'$amount' WHERE  id='$to_user' ";

                if ($db->query($sql) === TRUE) {
                    $transaction_historysql = "INSERT INTO transaction_history (from_user, to_user, amount, transaction_date)
					VALUES ('$from_user', '$to_user', '$amount', '$transaction_date')";

                    if ($db->query($transaction_historysql) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successful";
                        $row["message"] = "New record successfully created";
                        $data = $row;
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }


        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }

}
if (isset($_POST["completecarejob"])) {
    $sp_id = $authUser["id"];
    $spacceptjob = cleanInput($_POST["completecarejob"]);

    $caresql = "SELECT * FROM care WHERE id='$spacceptjob'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $caredata = $row;
        $sql = "UPDATE care SET request_status='Completed', sp_id='$sp_id' WHERE id='$spacceptjob'";
        if ($db->query($sql) === TRUE) {

            $from_user = cleanInput($caredata["requesterid"]);
            $to_user = cleanInput($sp_id);
            $amount = cleanInput($caredata["careprice"]);
            $transaction_date = $currentdatetime;
            $sql = "UPDATE users SET wallet=wallet-'$amount' WHERE  id='$from_user' ";

            if ($db->query($sql) === TRUE) {
                $sql = "UPDATE users SET wallet=wallet+'$amount' WHERE  id='$to_user' ";

                if ($db->query($sql) === TRUE) {
                    $transaction_historysql = "INSERT INTO transaction_history (from_user, to_user, amount, transaction_date)
					VALUES ('$from_user', '$to_user', '$amount', '$transaction_date')";

                    if ($db->query($transaction_historysql) === TRUE) {
                        $row["card"] = "green";
                        $row["status"] = "Successful";
                        $row["message"] = "New record successfully created";
                        $data = $row;
                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }


        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }

}

if (isset($_POST["spacceptjob"])) {
    $sp_id = $authUser["id"];
    $spacceptjob = cleanInput($_POST["spacceptjob"]);
    $sql = "UPDATE care SET request_status='Accepted', sp_id='$sp_id' WHERE id='$spacceptjob'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}

if (isset($_POST["startedThiscarejob"])) {
    $sp_id = $authUser["id"];
    $spacceptjob = cleanInput($_POST["startedThiscarejob"]);
    $sql = "UPDATE care SET request_status='Started', sp_id='$sp_id' WHERE id='$spacceptjob'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}


if (isset($_POST["universalviewallcare"])) {
    if ($authUser["provider_type"] == "Doctor") {
        $sql = "SELECT * FROM care WHERE request_status = 'New'";
    } else {
        $sql = "SELECT * FROM care WHERE request_status = 'New' AND caretypeori='House Call'";
    }

    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["caredate"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["caredate"] . " " . $row["caretime"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $d1 = new DateTime($timestamp);
            $d2 = new DateTime($currentdatetime);
            $interval = $d1->diff($d2);
            $row["hourleft"] = ($interval->days * 24) + $interval->h;
            $row["expired"] = false;
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            if ($row["expired"] == false) {
                $available[] = $row;
            }

        }
    } else {
        $available = "Empty";
    }


    $sp_id = $authUser["id"];
    $sql = "SELECT * FROM care WHERE request_status='Accepted' AND sp_id='$sp_id' OR request_status ='Started' AND sp_id='$sp_id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $today_date = new DateTime($today);
            $request_date = new DateTime($row["caredate"]);
            if ($request_date < $today_date) {
                $row["expired"] = true;
            } else {
                $row["expired"] = false;
            }
            $row["price"] = 120.00;
            $timestamp = $row["caredate"] . " " . $row["caretime"];
            $row["timestamp"] = $timestamp;
            $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
            $date1 = $timestamp;
            $date2 = $currentdatetime;
            $timestamp1 = strtotime($date1);
            $timestamp2 = strtotime($date2);
            $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
            $inprogress[] = $row;
        }
    } else {
        $inprogress = "Empty";
    }
    $data["available"] = $available;
    $data["inprogress"] = $inprogress;
    $data["provider_type"] = $authUser["provider_type"];

}
if (isset($_POST["cancelcare"])) {
    $id = cleanInput($_POST["cancelcare"]);
    $sql = "UPDATE care SET request_status='Canceled' WHERE id='$id'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The request has been canceled successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["customerviewcarerequest"])) {
    $id = cleanInput($_POST["customerviewcarerequest"]);
    $caresql = "SELECT * FROM care WHERE id='$id'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $requester = $row["requesterid"];
        $requestersql = "SELECT firstname, lastname, gender, lat, lng, profile_img, phonenumber  FROM users WHERE id='$requester'";
        $requesterresult = $db->query($requestersql);
        if ($requesterresult->num_rows > 0) {
            $requester = $requesterresult->fetch_assoc();
            $fullname = $requester["firstname"] . " " . $requester["lastname"];
            $row["patient"] = $requester;
        }

        $serviceproviderid = $row["sp_id"];
        $userssql = "SELECT firstname, lastname, gender, provider_type, gender, lat, lng, profile_img, phonenumber  FROM users WHERE id='$serviceproviderid'";
        $usersresult = $db->query($userssql);
        if ($usersresult->num_rows > 0) {
            $rows = $usersresult->fetch_assoc();
            if ($rows["provider_type"] == "Doctor") {
                $rows["designation"] = "Dr.";
            } else {
                $rows["provider_type"] = "Doctor";
                if ($rows["gender"] == "Male") {
                    $rows["designation"] = "Mr.";
                } else {
                    $rows["designation"] = "Ms.";
                }
            }

            $row["sp"] = $rows;

        }
        $cinfoid = cleanInput($row["careid"]);
        $ecare_servicessql = "SELECT * FROM ecare_services WHERE id='$cinfoid'";
        $ecare_servicesresult = $db->query($ecare_servicessql);
        $servicedata = $ecare_servicesresult->fetch_assoc();
        $row["servicedata"] = $servicedata;

        $timestamp = $row["caredate"] . " " . $row["caretime"];
        $row["timestamp"] = $timestamp;
        $row["timer"] = date("g:i a F jS, Y ", strtotime($timestamp));
        $date1 = $timestamp;
        $date2 = $currentdatetime;
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);
        $row["hours"] = abs($timestamp2 - $timestamp1) / (60 * 60);
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "This request doesnt exist";
        $data = $row;
    }
}
if (isset($_POST["inserttocare"])) {
    $caredate = cleanInput($_POST["caredate"]);
    $careid = cleanInput($_POST["careid"]);
    $caretime = cleanInput($_POST["caretime"]);
    $patientname = cleanInput($_POST["patientname"]);
    $patientproblem = cleanInput($_POST["patientproblem"]);
    $patientaddress = cleanInput($_POST["patientaddress"]);
    $addresslandmark = cleanInput($_POST["addresslandmark"]);
    $requesterid = cleanInput($_POST["requesterid"]);
    $lat = cleanInput($_POST["lat"]);
    $lng = cleanInput($_POST["lng"]);
    $request_status = "New";
    $doc_id = 0;
    $caretype = cleanInput($_POST["caretype"]);
    $caretypeori = cleanInput($_POST["caretypeori"]);
    if ($caretypeori == "House Call") {
        $ecare_servicessql = "SELECT * FROM ecare_services WHERE id='$careid'";
        $ecare_servicesresult = $db->query($ecare_servicessql);
        $ecare_servicesdata = $ecare_servicesresult->fetch_assoc();
        $careprice = $ecare_servicesdata["price"];
    } else {
        $ecare_servicessql = "SELECT * FROM ecare_services WHERE id='$careid'";
        $ecare_servicesresult = $db->query($ecare_servicessql);
        $ecare_servicesdata = $ecare_servicesresult->fetch_assoc();
        $careprice = $ecare_servicesdata["walkinprice"];
    }
    $fullname = cleanInput($_POST["fullname"]);
    $noic = cleanInput($_POST["noic"]);
    $knownillness = cleanInput($_POST["knownillness"]);

    if ($_POST["packagedata"] != "None" && $caretype != "Custom Consultation") {

        if ($caretype != "Custom Consultation") {
            $packagedata = json_decode($_POST["packagedata"]);

            $apdate = $caredate . ' ' . $caretime;
            $packagedata[0]->appointment_date = $apdate;
            $packagedata = json_encode($packagedata);
            $packagedata = cleanInput($packagedata);
        } else {
            $packagedata = "None";
        }
    } else {
        $packagedata = "None";
    }
    $require_attachment = cleanInput($_POST["require_attachment"]);
    $caresql = "INSERT INTO care (caredate, caretime, patientname, patientproblem, patientaddress, addresslandmark, requesterid, lat, lng, request_status, sp_id, caretype, fullname, noic, knownillness, careprice, caretypeori, packages_data, require_attachment, careid)
		VALUES ('$caredate', '$caretime', '$patientname', '$patientproblem', '$patientaddress', '$addresslandmark', '$requesterid', '$lat', '$lng', '$request_status', '$doc_id', '$caretype', '$fullname', '$noic', '$knownillness', '$careprice', '$caretypeori', '$packagedata', '$require_attachment', '$careid')";

    if ($db->query($caresql) === TRUE) {
        $last_id = $db->insert_id;
        $row["card"] = "green";
        $row["last_id"] = $last_id;
        $row["status"] = "Successful";
        $row["message"] = "New record successfully created";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
        $data = $row;
    }
}
if (isset($_POST["searchcareterm"])) {
    $pname = cleanInput($_POST["searchcareterm"]);
    $sql = "SELECT * FROM ecare_services WHERE name LIKE '%$pname%'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Not Found";
        $data = $row;
    }
}
if (isset($_POST["viewspeccare"])) {
    $viewspeccare = cleanInput($_POST["viewspeccare"]);
    $sql = "SELECT * FROM ecare_services WHERE id = '$viewspeccare'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Not Found";
        $data = $row;
    }
}
if (isset($_POST["submitaccounts_verification_nurse"])) {
    $owner = $authUser["id"];
    $request_status = "New";
    $verifying_for = cleanInput($_POST["verifying_for"]);
    $registeration_body = cleanInput($_POST["registeration-bodies"]);
    $educations_place = cleanInput($_POST["educations_place"]);
    $apc_number = cleanInput($_POST["apc_number"]);

    $organization_name = cleanInput($_POST["editorganization_name"]);
    $organization_designation = cleanInput($_POST["editorganization_designation"]);
    $organization_address = cleanInput($_POST["editorganization_address"]);
    $organization_city = cleanInput($_POST["editorganization_city"]);
    $organization_state = cleanInput($_POST["editorganization_state"]);
    $organization_postcode = cleanInput($_POST["editorganization_postcode"]);
    $organization_country = cleanInput($_POST["editorganization_country"]);
    $organization_phone_number = cleanInput($_POST["editorganization_phone_number"]);
    $organization_fax_number = cleanInput($_POST["editorganization_fax_number"]);
    $organization_registeration_number = cleanInput($_POST["editorganization_registeration_number"]);

    $ic_font = cleanInput($_POST["ic_font"]);
    $ic_back = cleanInput($_POST["ic_back"]);
    $education_certification = cleanInput($_POST["education_certification"]);
    $apc_file = cleanInput($_POST["apc_file"]);
    if ($verifying_for == "Caregiver" || $verifying_for == "Optometrist" || $verifying_for == "Occupational Therapist") {
        if ($request_status != "" && $owner != "" && $verifying_for != "" && $ic_font != "" && $ic_back != "" && $educations_place != "" && $education_certification != "") {
            $sql = "UPDATE accounts_verification SET request_status='New', verifying_for='$verifying_for', ic_font='$ic_font', ic_back='$ic_back', educations_place='$educations_place', education_certification='$education_certification', apc_number='$apc_number', apc_file='$apc_file', registeration_body='$registeration_body' WHERE owner='$owner'";

            if ($db->query($sql) === TRUE) {
                $sqlupdateuser = "UPDATE users SET verified_service_provider='Requested', organization_name='$organization_name', organization_designation='$organization_designation', organization_address='$organization_address', organization_city='$organization_city', organization_state='$organization_state', organization_postcode='$organization_postcode', organization_country='$organization_country', organization_phone_number='$organization_phone_number', organization_fax_number='$organization_fax_number', organization_registeration_number='$organization_registeration_number' WHERE id='$owner'";
                if ($db->query($sqlupdateuser) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    $row["message"] = "Your request will be reviewed and you will get confirmation within 1-3 day";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Fail to process your request. Please try again";
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    } else {
        if ($request_status != "" && $owner != "" && $verifying_for != "" && $ic_font != "" && $ic_back != "" && $educations_place != "" && $education_certification != "" && $apc_number != "" && $apc_file != "" && $organization_name != "") {
            $sql = "UPDATE accounts_verification SET request_status='New', verifying_for='$verifying_for', ic_font='$ic_font', ic_back='$ic_back', educations_place='$educations_place', education_certification='$education_certification', apc_number='$apc_number', apc_file='$apc_file', registeration_body='$registeration_body' WHERE owner='$owner'";

            if ($db->query($sql) === TRUE) {
                $sqlupdateuser = "UPDATE users SET verified_service_provider='Requested', organization_name='$organization_name', organization_designation='$organization_designation', organization_address='$organization_address', organization_city='$organization_city', organization_state='$organization_state', organization_postcode='$organization_postcode', organization_country='$organization_country', organization_phone_number='$organization_phone_number', organization_fax_number='$organization_fax_number', organization_registeration_number='$organization_registeration_number' WHERE id='$owner'";
                if ($db->query($sqlupdateuser) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successfull";
                    $row["message"] = "Your request will be reviewed and you will get confirmation within 1-3 day";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Fail to process your request. Please try again";
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    }

}
if (isset($_POST["viewallecare_services"])) {
    $cat = cleanInput($_POST["viewallecare_services"]);
    if ($_POST["viewallecare_services"] == "true") {
        $sql = "SELECT * FROM ecare_services";
    } else {
        $sql = "SELECT * FROM ecare_services WHERE category='$cat'";
    }

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["viewallecare_serviceswithsub"])) {
    $cat = cleanInput($_POST["viewallecare_serviceswithsub"]);
    $syv = cleanInput($_POST["subcate"]);

    $sql = "SELECT * FROM ecare_services WHERE category='$cat' AND subcategory='$syv'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["viewThiselab_request"])) {
    $id = cleanInput($_POST["viewThiselab_request"]);
    $elab_requestsql = "SELECT * FROM elab_request WHERE id='$id'";
    $elab_requestresult = $db->query($elab_requestsql);
    if ($elab_requestresult->num_rows > 0) {
        $row = $elab_requestresult->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "";
        $data = $row;
    }
}
if (isset($_POST["viewallelab_request"])) {
    $requester = $authUser["id"];
    $sql = "SELECT * FROM elab_request WHERE requester='$requester'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["sample_collection_date"] = date("F jS, Y", strtotime($row["sample_collection_date"]));
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["submitelab_request"])) {
    $requester = $authUser["id"];
    $service_id = cleanInput($_POST["service_id"]);
    $service_name = cleanInput($_POST["service_name"]);
    $sample_collection_date = cleanInput($_POST["sample_collection_date"]);
    $request_address = cleanInput($_POST["address"]);
    $price = cleanInput($_POST["price"]);
    $request_status = "New";
    $request_report = "Not Set";
    if ($requester != "" && $service_id != "" && $service_name != "" && $sample_collection_date != "" && $request_status != "" && $request_report != "" && $request_address != "") {
        $elab_requestsql = "INSERT INTO elab_request (requester, service_id, service_name, sample_collection_date, request_status, request_report, request_address)
		VALUES ('$requester', '$service_id', '$service_name', '$sample_collection_date', '$request_status', '$request_report', '$request_address')";
        if ($db->query($elab_requestsql) === TRUE) {
            $last_id = $db->insert_id;
            $row["last_id"] = $last_id;
            $sqls = "UPDATE users SET wallet=wallet-'$price' WHERE  id='$requester'";
            if ($db->query($sqls) === TRUE) {
                $last_id = $db->insert_id;
                $row["last_id"] = $last_id;
                $row["status"] = "successful";
                $row["message"] = "Your request has been succesfully recieved";
                $data = $row;
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["viewarticle"])) {
    $id = cleanInput($_POST["viewarticle"]);
    $elab_servicesql = "SELECT * FROM blogs WHERE id='$id'";
    $elab_serviceresult = $db->query($elab_servicesql);
    if ($elab_serviceresult->num_rows > 0) {
        $row = $elab_serviceresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "This service is unavailable";
        $data = $row;
    }
}
if (isset($_POST["viewthisElab"])) {
    $id = cleanInput($_POST["viewthisElab"]);
    $elab_servicesql = "SELECT * FROM elab_service WHERE id='$id'";
    $elab_serviceresult = $db->query($elab_servicesql);
    if ($elab_serviceresult->num_rows > 0) {
        $row = $elab_serviceresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "This service is unavailable";
        $data = $row;
    }
}
if (isset($_POST["viewallelab_service"])) {
    $category = cleanInput($_POST["viewallelab_service"]);
    $sub = cleanInput($_POST["sub"]);
    if ($sub == "Not Set") {
        $sql = "SELECT * FROM elab_service WHERE category='$category'";
    } else {
        $sql = "SELECT * FROM elab_service WHERE category='$category' AND subcategory='$sub'";
    }


    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["description"] = mb_strimwidth($rowey2["description"], 0, 10, "...");
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["verifytrustgate"])) {
    $id = $authUser["id"];
    $verify_MembershipNo = cleanInput($_POST["editverify_MembershipNo"]);
    $verify_CertValidity = cleanInput($_POST["editverify_CertValidity"]);
    $verify_NRICFront = cleanInput($_POST["editverify_NRICFront"]);
    $verify_NRICBack = cleanInput($_POST["editverify_NRICBack"]);
    $verify_PassportImage = cleanInput($_POST["editverify_PassportImage"]);
    $verify_orgUserDesignation = cleanInput($_POST["editverify_orgUserDesignation"]);


    $verify_orgAddress = cleanInput($_POST["editverify_orgAddress"]);
    $verify_orgAddressCity = cleanInput($_POST["editverify_orgAddressCity"]);
    $verify_orgAddressPostcode = cleanInput($_POST["editverify_orgAddressPostcode"]);
    $verify_orgAddressCountry = cleanInput($_POST["editverify_orgAddressCountry"]);
    $verify_orgRegistationNo = cleanInput($_POST["editverify_orgRegistationNo"]);
    $verify_orgPhoneNo = cleanInput($_POST["editverify_orgPhoneNo"]);
    $verify_orgFaxNo = cleanInput($_POST["editverify_orgFaxNo"]);
    $verify_UserID = cleanInput($_POST["editverify_UserID"]);

    $OrganisationInfo = array('orgName' => $orgName, 'orgUserDesignation' => $orgUserDesignation, 'orgAddress' => $orgAddress, 'orgAddressCity' => $orgAddressCity, 'orgAddressState' => $orgAddressState, 'orgAddressPostcode' => $orgAddressPostcode, 'orgAddressCountry' => $orgAddressCountry, 'orgRegistationNo' => $orgRegistationNo, 'orgPhoneNo' => $orgPhoneNo, 'orgFaxNo' => $orgFaxNo,);
    $data["organization info"] = json_encode($OrganisationInfo);


    /* 	$sql = "UPDATE users SET approved_by_trustgate='true', verify_MembershipNo='$verify_MembershipNo', verify_CertValidity='$verify_CertValidity', verify_NRICFront='$verify_NRICFront', verify_NRICBack='$verify_NRICBack', verify_PassportImage='$verify_PassportImage', verify_orgUserDesignation='$verify_orgUserDesignation', verify_orgAddress='$verify_orgAddress', verify_orgAddressCity='$verify_orgAddressCity', verify_orgAddressPostcode='$verify_orgAddressPostcode', verify_orgAddressCountry='$verify_orgAddressCountry', verify_orgRegistationNo='$verify_orgRegistationNo', verify_orgPhoneNo='$verify_orgPhoneNo', verify_orgFaxNo='$verify_orgFaxNo', verify_UserID='$verify_UserID' WHERE  id='$id'";

	if ($db->query($sql) === TRUE) {
		$row["card"] = "green";
		$row["status"] = "Successfull";
		$row["message"] = "The record has been updated successfully";
		$data = $row;
	} else {
		$row["card"] = "red";
		$row["status"] = "Fail";
		$row["message"] = "Error updating record: " . $db->error;
		$data = $row;
	} */
}
if (isset($_POST["viewlatestcall"])) {
    $callssql = "SELECT * FROM calls WHERE reciver='$id' AND call_request > date_sub(now(), interval 2 minute)";
    $callsresult = $db->query($callssql);
    if ($callsresult->num_rows > 0) {
        $row = $callsresult->fetch_assoc();
        $callsdata = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }
}
if (isset($_POST["viewThiscalls"])) {
    $id = cleanInput($_POST["viewThiscalls"]);
    $callssql = "SELECT * FROM calls WHERE id='$id' AND call_request > date_sub(now(), interval 2 minute)";
    $callsresult = $db->query($callssql);
    if ($callsresult->num_rows > 0) {
        $row = $callsresult->fetch_assoc();
        $callsdata = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "No call";
        $data = $row;
    }
}
if (isset($_POST["paysession"])) {
    $patientid = $authUser["id"];
    $id = cleanInput($_POST["paysession"]);
    $deliverytype = cleanInput($_POST["deliverytype"]);
    $sessioncost = cleanInput($_POST["sessioncost"]);
    $docprice = cleanInput($_POST["docprice"]);
    if ($authUser["wallet"] >= $sessioncost) {
        $sql2 = "UPDATE users SET wallet=wallet - '$docprice' WHERE  id='$patientid'";
        $db->query($sql2);
        $deliver_address = cleanInput($_POST["deliveryaddress"]);
        $deliver_fee = cleanInput($_POST["deliveryfee"]);
        if ($deliverytype == "Pickup") {
            $sql = "UPDATE chats SET paid='true', active='false', delivery_address='$deliver_address', delivery_fee='$deliver_fee', delivery_completed='waiting', delivery_type='$deliverytype' WHERE id='$id'";
            if ($db->query($sql) === TRUE) {
                $rowe["card"] = "green";
                $rowe["status"] = "Successfull";
                $rowe["message"] = "The record has been updated successfully";
                $rowe["mc"] = $mcfullurl;
                $rowe["pres"] = $pdfsignfullurl;
                $rowe["ori_mc"] = $chatsdata["saved_mc"];
                $rowe["ori_pres"] = $chatsdata["saved_pres"];
                $data = $rowe;
            } else {
                $rowe["card"] = "red";
                $rowe["status"] = "Fail";
                $rowe["message"] = "Error updating record: " . $db->error;
                $data = $rowe;
            }
        }

        if ($deliverytype == "Delivery") {
            include("delyva.php");
            $delyvacreatedata = cleanInput($_POST["delyvadata"]);
            $delyvacreatedata = base64_decode($delyvacreatedata);
            $delyvacreatedata = json_decode($delyvacreatedata);
            $delyva = new Delyva;
            $accessToken = $delyva->auth();
            $request = $delyva->createOrder($delyvacreatedata);
            $delyva_order_id = $request->data->id;
            $delyvastatuscode = $request->data->statusCode;
            $data["request"] = $request;
            $data["delyva_order_id"] = $delyva_order_id;
            $data["delyvacreatedata"] = $delyvacreatedata;
            $data["delyvastatuscode"] = $delyvastatuscode;
            $data["status"] = "Fail";
            $data["message"] = "Please check";
            $delyva_service_code = $delyvacreatedata->serviceCode;
            $sql = "UPDATE chats SET paid='true', active='false', delivery_address='$deliver_address', delivery_fee='$deliver_fee', delivery_completed='waiting', delivery_type='$deliverytype', delyva_order_id='$delyva_order_id', delyva_service_code='$delyva_service_code', delyva_order_status='0' WHERE id='$id'";
            if ($db->query($sql) === TRUE) {
                $rowe["card"] = "green";
                $rowe["status"] = "Successfull";
                $rowe["message"] = "The record has been updated successfully";
                $rowe["mc"] = $mcfullurl;
                $rowe["pres"] = $pdfsignfullurl;
                $rowe["ori_mc"] = $chatsdata["saved_mc"];
                $rowe["ori_pres"] = $chatsdata["saved_pres"];
                $data = $rowe;
            } else {
                $rowe["card"] = "red";
                $rowe["status"] = "Fail";
                $rowe["message"] = "Error updating record: " . $db->error;
                $data = $rowe;
            }
        }


    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please top up your account";
        $data = $row;
    }
}
if (isset($_POST["endsession"])) {
    $id = cleanInput($_POST["endsession"]);
    $diagnose = cleanInput($_POST["editdiagnose"]);
    $prescription = cleanInput($_POST["editprescription"]);
    if ($prescription == "[]") {
        $prescription = "None";
    }
    $mcdata = cleanInput($_POST["mcdata"]);
    $referdata = cleanInput($_POST["referdata"]);
    $clincalNote = cleanInput($_POST["clincalNote"]);
    $storeowner = cleanInput($_POST["storeowner"]);
    $pinnumber = cleanInput($_POST["pin"]);

    $sql = "UPDATE chats SET diagnose='$diagnose', clincalNote='$clincalNote', referto='$referdata', mcdata='$mcdata', prescription='$prescription', storeid='$storeowner', session_status='Ended', enddate='$currentdatetime', endtime='$currenttime', sppaid='true' WHERE  id='$id'";
    if ($db->query($sql) === TRUE) {

        $chatssql = "SELECT * FROM chats WHERE id='$id'";
        $chatsresult = $db->query($chatssql);
        if ($chatsresult->num_rows > 0) {
            $row = $chatsresult->fetch_assoc();
            $doctorprice = $row["doctorearning"];
            $error = 0;
            $er = "Error:-";
            include("trustgate.php");
            $rew["status"] = "Success";
            sleep(3);

            $pdf = file_get_contents('https://epink.health/clinicalnote/' . $id);
            file_put_contents('../api/clinicalnotes/saved' . $id . '.pdf', $pdf);
            $savedclinicalnote = 'https://epink.health/api/clinicalnotes/saved' . $id . '.pdf';
            $sqlx = "UPDATE chats SET savedclinicalnote='$savedclinicalnote' WHERE id='$id'";
            $db->query($sqlx);
            sleep(3);
            $docid = $authUser["id"];
            $docsql = "SELECT * FROM users WHERE id='$docid'";
            $resultdoc = $db->query($docsql);
            if ($resultdoc->num_rows > 0) {
                $docinfo = $resultdoc->fetch_assoc();
                $docfullname = $docinfo["firstname"] . ' ' . $docinfo["lastname"];
                $docic = $docinfo["ic_number"];
                $docsignatureurl = $docinfo["signaturefile"];
                $pdf = pdfToBase64($savedclinicalnote);
                $signature = imgToBase64($docsignatureurl);
                $SignatureDetails = array('visibility' => true, 'x1' => 300, 'y1' => 20, 'x2' => 500, 'y2' => 100, 'pageNo' => '1', 'pdfInBase64' => $pdf, 'sigImageInBase64' => $signature);
                $requestParameters = array('RequestID' => 0, 'UserID' => $docic, 'FullName' => $docfullname, 'AuthFactor' => $pinnumber, 'SignatureInfo' => $SignatureDetails);
                $result = $client->SignPDF($requestParameters);
                $res = $result->return;
                $response = json_encode($result->return);
                if ($res->signedPdfInBase64 != null) {
                    $pdfe = $res->signedPdfInBase64;
                    $file = base64_decode($pdfe);
                    $filename = 'clinicalnotes/' . rand(10000, 1000000) . uniqid() . '-signed.pdf';
                    file_put_contents($filename, $file);
                    $pdfsignfullurl = 'https://epink.health/api/' . $filename;
                    $sqlsigned = "UPDATE chats SET signedclinicalnote='$pdfsignfullurl' WHERE id='$id'";
                    $db->query($sqlsigned);
                    $signing["clinicalnote"] = $pdfsignfullurl;
                } else {
                    $error++;
                    $signing["clinicalnote"] = "failed";
                    $er = $res->statusMsg;
                    $signing["error1"] = $response;
                }
            }
            if ($row["prescription"] != "None") {
                $pdf = file_get_contents('https://epink.health/prescription/' . $id);
                file_put_contents('../api/prescription/saved/' . $id . '.pdf', $pdf);
                $saved_presURL = 'https://epink.health/api/prescription/saved/' . $id . '.pdf';
                $sqlx = "UPDATE chats SET saved_pres='$saved_presURL' WHERE id='$id'";
                $db->query($sqlx);
                sleep(3);
                $docid = $authUser["id"];
                $docsql = "SELECT * FROM users WHERE id='$docid'";
                $resultdoc = $db->query($docsql);
                if ($resultdoc->num_rows > 0) {
                    $docinfo = $resultdoc->fetch_assoc();
                    $docfullname = $docinfo["firstname"] . ' ' . $docinfo["lastname"];
                    $docic = $docinfo["ic_number"];
                    $docsignatureurl = $docinfo["signaturefile"];
                    $pdf = pdfToBase64($saved_presURL);
                    $signature = imgToBase64($docsignatureurl);
                    $SignatureDetails = array('visibility' => true, 'x1' => 300, 'y1' => 20, 'x2' => 500, 'y2' => 100, 'pageNo' => '1', 'pdfInBase64' => $pdf, 'sigImageInBase64' => $signature);
                    $requestParameters = array('RequestID' => 0, 'UserID' => $docic, 'FullName' => $docfullname, 'AuthFactor' => $pinnumber, 'SignatureInfo' => $SignatureDetails);
                    $result = $client->SignPDF($requestParameters);
                    $res = $result->return;
                    $response = json_encode($result->return);
                    if ($res->signedPdfInBase64 != null) {
                        $pdfe = $res->signedPdfInBase64;
                        $file = base64_decode($pdfe);
                        $filename = 'prescription/' . rand(10000, 1000000) . uniqid() . '-signed.pdf';
                        file_put_contents($filename, $file);
                        $pdfsignfullurl = 'https://epink.health/api/' . $filename;
                        $sqlsigned = "UPDATE chats SET signedpres='$pdfsignfullurl' WHERE id='$id'";
                        $db->query($sqlsigned);
                        $signing["prescription"] = $pdfsignfullurl;

                    } else {
                        $signing["prescription"] = "failed";
                        $error++;
                        $er = $res->statusMsg;
                    }
                }
            } else {
                $signing["prescription"] = "No prescription";
                $sqlop = "UPDATE chats SET active='false' WHERE  id='$id'";
                $db->query($sqlop);
            }

            if ($row["mcdata"] != "None") {
                $pdfmc = file_get_contents('https://epink.health/mc/' . $id);
                file_put_contents('../api/mcs/saved/' . $id . '.pdf', $pdfmc);
                $saved_mcURL = 'https://epink.health/api/mcs/saved/' . $id . '.pdf';
                $sqlx = "UPDATE chats SET signedmc='$saved_mcURL' WHERE id='$id'";
                $db->query($sqlx);
                sleep(3);
                $docid = $authUser["id"];
                $docsql = "SELECT * FROM users WHERE id='$docid'";
                $resultdoc = $db->query($docsql);
                if ($resultdoc->num_rows > 0) {
                    $docinfo = $resultdoc->fetch_assoc();
                    $docfullname = $docinfo["firstname"] . ' ' . $docinfo["lastname"];
                    $docic = $docinfo["ic_number"];
                    $docsignatureurl = $docinfo["signaturefile"];
                    $pdf = pdfToBase64($saved_mcURL);
                    $signature = imgToBase64($docsignatureurl);

                    $SignatureDetails = array('visibility' => true, 'x1' => 300, 'y1' => 20, 'x2' => 500, 'y2' => 100, 'pageNo' => '1', 'pdfInBase64' => $pdf, 'sigImageInBase64' => $signature);

                    $requestParameters = array('RequestID' => 0, 'UserID' => $docic, 'FullName' => $docfullname, 'AuthFactor' => $pinnumber, 'SignatureInfo' => $SignatureDetails);
                    $result = $client->SignPDF($requestParameters);
                    $res = $result->return;
                    $response = json_encode($result->return);
                    if ($res->signedPdfInBase64 != null) {
                        $pdfe = $res->signedPdfInBase64;
                        $file = base64_decode($pdfe);
                        $filename = 'mcs/' . rand(10000, 1000000) . uniqid() . '-signed.pdf';
                        file_put_contents($filename, $file);
                        $pdfsignfullurl = 'https://epink.health/api/' . $filename;
                        $sqlsigned = "UPDATE chats SET signedmc='$pdfsignfullurl' WHERE id='$id'";
                        $db->query($sqlsigned);
                        $signing["mc"] = $pdfsignfullurl;
                    } else {
                        $error++;
                        $signing["mc"] = "failed";
                        $signing["mc_fail_reason"] = $response;
                        $er = $res->statusMsg;
                    }
                }
            } else {
                $signing["mc"] = "No mc";
            }

            if ($row["referto"] != "None") {
                $referrawfile = file_get_contents('https://epink.health/referdoc/' . $id);
                file_put_contents('../api/refer/rawsaved' . $id . '.pdf', $referrawfile);
                $savedrefer = 'https://epink.health/api/refer/rawsaved' . $id . '.pdf';
                $sqlx = "UPDATE chats SET savedrefer='$savedrefer' WHERE id='$id'";
                $db->query($sqlx);
                sleep(3);
                $docid = $authUser["id"];
                $docsql = "SELECT * FROM users WHERE id='$docid'";
                $resultdoc = $db->query($docsql);
                if ($resultdoc->num_rows > 0) {
                    $docinfo = $resultdoc->fetch_assoc();
                    $docfullname = $docinfo["firstname"] . ' ' . $docinfo["lastname"];
                    $docic = $docinfo["ic_number"];
                    $docsignatureurl = $docinfo["signaturefile"];
                    $referpdf = pdfToBase64($savedrefer);
                    $signature = imgToBase64($docsignatureurl);

                    $SignatureDetails = array('visibility' => true, 'x1' => 300, 'y1' => 20, 'x2' => 500, 'y2' => 100, 'pageNo' => '1', 'pdfInBase64' => $referpdf, 'sigImageInBase64' => $signature);

                    $requestParameters = array('RequestID' => 0, 'UserID' => $docic, 'FullName' => $docfullname, 'AuthFactor' => $pinnumber, 'SignatureInfo' => $SignatureDetails);
                    $result = $client->SignPDF($requestParameters);
                    $res = $result->return;
                    $response = json_encode($result->return);
                    if ($res->signedPdfInBase64 != null) {
                        $pdfe = $res->signedPdfInBase64;
                        $file = base64_decode($pdfe);


                        $filename = 'refer/' . rand(10000, 1000000) . uniqid() . '-signed.pdf';
                        file_put_contents($filename, $file);
                        $signedrefer = 'https://epink.health/api/' . $filename;
                        $sqlsigned = "UPDATE chats SET signedrefer='$signedrefer' WHERE id='$id'";
                        $db->query($sqlsigned);
                        $signing["referral"] = $signedrefer;
                    } else {
                        $error++;
                        $signing["referral"] = "failed";
                        $signing["referral_fail_reason"] = $response;
                        $er = $res->statusMsg;
                    }
                }
            } else {
                $signing["referral"] = "No referral";
            }

            if ($error == 0) {
                $docid = $authUser["id"];
                $sql = "UPDATE users SET wallet=wallet +'$doctorprice' WHERE id='$docid'";
                $db->query($sql);
                insertTransaction(0, $docid, $doctorprice, "Tele consultation fee");
                sendNotification($docid, 'Payment received', 'You have recieved RM' . $doctorprice . '. Please check your wallet.');
                $endsession["status"] = "success";
                $endsession["signing"] = $signing;
                $endsession["errormessage"] = $errormessage;
            } else {
                $errormessage = $er;
                $sql = "UPDATE chats SET session_status='New', sppaid='false' WHERE  id='$id'";
                $db->query($sql);
                $endsession["status"] = "fail";
                $endsession["signing"] = $signing;
                $endsession["errormessage"] = $errormessage . ' Error Number: ' . $error;
                $endsession["trusterrror"] = $response;
            }
            $data = $endsession;


        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
            $data = $row;
        }

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }

}
if (isset($_POST["endsessionold"])) {
    $id = cleanInput($_POST["endsession"]);
    $diagnose = cleanInput($_POST["editdiagnose"]);
    $prescription = cleanInput($_POST["editprescription"]);
    $mcdata = cleanInput($_POST["mcdata"]);
    $referdata = cleanInput($_POST["referdata"]);
    $clincalNote = cleanInput($_POST["clincalNote"]);
    $storeowner = cleanInput($_POST["storeowner"]);
    $pinnumber = cleanInput($_POST["storeowner"]);

    $sql = "UPDATE chats SET session_status='Ended', diagnose='$diagnose', clincalNote='$clincalNote', referto='$referdata', mcdata='$mcdata', prescription='$prescription', storeid='$storeowner' WHERE  id='$id'";
    if ($db->query($sql) === TRUE) {
        $pdf = file_get_contents('https://epink.health/prescription/' . $id);
        file_put_contents('../api/prescription/saved/' . $id . '.pdf', $pdf);
        $saved_presURL = 'https://epink.health/api/prescription/saved/' . $id . '.pdf';
        $pdfmc = file_get_contents('https://epink.health/mc/' . $id);
        file_put_contents('../api/prescription/saved/mc' . $id . '.pdf', $pdfmc);
        $saved_mcURL = 'https://epink.health/api/prescription/saved/' . $id . '.pdf';
        $sqlx = "UPDATE chats SET saved_pres='$saved_presURL', saved_mc='$saved_mcURL' WHERE id='$id'";
        $db->query($sqlx);
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["viewallproducts"])) {
    $pname = cleanInput($_POST["viewallproducts"]);
    $pid = cleanInput($_POST["pharmaid"]);
    if ($pid == 0) {
        $sql = "SELECT * FROM products WHERE name LIKE '%$pname%' LIMIT 10";
    } else {
        $sql = "SELECT * FROM products WHERE name LIKE '%$pname%' AND owner='$pid' LIMIT 10";
    }

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["vendor_name"] = getVendorprofile($row["owner"]);
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Not Found";
        $data = $row;
    }
}
if (isset($_POST["docdashboard"])) {
    $data["trustgate"] = $authUser["approved_by_trustgate"];
    $docid = $authUser["id"];
    if ($authUser["approved_by_trustgate"] == "true") {
        //Get Active Session
        $chatssql = "SELECT * FROM chats WHERE active='true' AND owner_one='$docid' OR active='true' AND owner_two='$docid'";
        $chatsresult = $db->query($chatssql);
        if ($chatsresult->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["owner_one"] != $authUser["id"]) {
                    $row["profile_img"] = getProfilePicture($row["owner_one"]);
                } else {
                    $row["profile_img"] = getProfilePicture($row["owner_one"]);
                }
                $chatsdata[] = $row;
            }
            $data["session_count"] = $chatsresult->num_rows;
        } else {
            $chatsdata = null;
            $data["session_count"] = 0;
        }

        $data["sessions"] = $chatsdata;
        $sql = "SELECT * FROM care WHERE request_status='New'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $row["fullname"] = getPatientFullname($row["requesterid"]);

                $caredata[] = $row;
            }
        } else {
            $caredata = null;
        }
        $data["care"] = $caredata;
    } else {

    }

}
if (isset($_POST["viewallcare"])) {
    $ownerid = $authUser["id"];
    $sql = "SELECT * FROM care WHERE requesterid='$ownerid' ORDER BY id DESC";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $cinfoid = cleanInput($row["careid"]);
            $ecare_servicessql = "SELECT * FROM ecare_services WHERE id='$cinfoid'";
            $ecare_servicesresult = $db->query($ecare_servicessql);
            $servicedata = $ecare_servicesresult->fetch_assoc();
            $row["servicedata"] = $servicedata;
            $dates = $row["care_date"] . ' ' . $row["care_time"];
            $row["fulldate"] = $row["care_date"] . '' . $row["care_time"];
            $row["datetime"] = humanreadabledatetime($dates);
            $data[] = $row;

        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["custviewThischats"])) {
    $id = cleanInput($_POST["custviewThischats"]);
    $chatssql = "SELECT * FROM chats WHERE id='$id'";
    $chatsresult = $db->query($chatssql);
    if ($chatsresult->num_rows > 0) {
        $row = $chatsresult->fetch_assoc();
        $owneroneid = $row["owner_one"];
        $ownertwoid = $row["owner_two"];
        $row["owner_one_info"] = getsimpleProfile($owneroneid);
        $row["owner_two_info"] = getsimpleProfile($ownertwoid);
        if ($row["service_status"] == "Ended") {

        }
        if ($row["storeid"] != 0) {
            $storeid = $row["storeid"];
            $sqlstore = "SELECT vendor_address, lat, lng FROM users WHERE id='$storeid'";
            $resultstore = $db->query($sqlstore);
            if ($resultstore->num_rows > 0) {
                $storeinfo = $resultstore->fetch_assoc();
            }
        }
        $reviewssql = "SELECT * FROM reviews WHERE job_id='$id' AND job_type='Consultation'";
        $reviewsresult = $db->query($reviewssql);
        if ($reviewsresult->num_rows > 0) {
            $reviewdata = $reviewsresult->fetch_assoc();

        } else {
            $reviewdata = null;

        }
        if ($row["storeid"] != 0) {
            $row["vendor_profile"] = getVendorprofile($row["storeid"]);
        }
        $delyvadata = null;
        $adata = [];
        if ($row["prescription"] != null || $row["prescription"] != "") {
            $inventorydata = json_decode($row["prescription"]);
            $icount = COUNT($inventorydata);
            for ($x = 0; $x < $icount; $x++) {
                $arrayVar = [
                    "name" => $inventorydata[$x]->name,
                    "type" => "PARCEL",
                    "price" => ["amount" => (float)$inventorydata[$x]->price, "currency" => "MYR"],
                    "weight" => ["value" => (int)$inventorydata[$x]->weight, "unit" => $inventorydata[$x]->weightunit],
                    "dimension" => [
                        "width" => (int)$inventorydata[$x]->width,
                        "height" => (int)$inventorydata[$x]->height,
                        "length" => (int)$inventorydata[$x]->length,
                        "unit" => "cm",
                    ],
                    "quantity" => 1,
                    "description" => "Description Not Set",
                ];
                array_push($adata, $arrayVar);
            }
            $sender = $row["vendor_profile"];
            $origin = [
                "scheduledAt" => date(DATE_ISO8601, strtotime($currentdatetime)),
                "inventory" => $adata,
                "contact" => [
                    "name" => $sender["vendor_name"],
                    "email" => $sender["email"],
                    "phone" => $sender["phonenumber"],
                    "unitNo" => "",
                    "address1" => $sender["vendor_street_address"],
                    "address2" => $sender["vendor_street_address_2"],
                    "city" => $sender["vendor_city"],
                    "state" => $sender["vendor_state"],
                    "postcode" => $sender["vendor_postcode"],
                    "country" => "MY",
                    "coord" => ["lat" => $sender["lat"], "lon" => $sender["lng"]],
                ],
            ];
            if ($authUser["fullname"] == "" || $authUser["fullname"] == null) {
                $authUser["fullname"] = $authUser["firstname"] . ' ' . $authUser["lastname"];
            }
            $destination = [
                "inventory" => $adata,
                "contact" => [
                    "name" => $authUser["fullname"],
                    "email" => $authUser["email"],
                    "phone" => $authUser["phonenumber"],
                    "unitNo" => "",
                    "address1" => "",
                    "address2" => "",
                    "city" => "",
                    "state" => "",
                    "postcode" => "",
                    "country" => "MY",
                    "coord" => ["lat" => "", "lon" => ""],
                ],
            ];
            include("delyva.php");
            $delyvadata["customerId"] = $customer_ID;
            $delyvadata["process"] = false;
            $delyvadata["serviceCode"] = "";
            $delyvadata["origin"] = $origin;
            $delyvadata["destination"] = $destination;
        }


        $row["delyvadata"] = $delyvadata;
        $row["review_data"] = $reviewdata;
        $row["store_info"] = $storeinfo;
        $data = $row;
    } else {

        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;

    }
}
if (isset($_POST["docviewThischats"])) {
    $id = cleanInput($_POST["docviewThischats"]);
    $chatssql = "SELECT * FROM chats WHERE id='$id'";
    $chatsresult = $db->query($chatssql);
    if ($chatsresult->num_rows > 0) {

        $row = $chatsresult->fetch_assoc();
        $owneroneid = $row["owner_one"];
        $ownertwoid = $row["owner_two"];
        $row["owner_one_info"] = getsimpleProfile($owneroneid);
        $row["owner_two_info"] = getsimpleProfile($ownertwoid);
        $row["session_date"] = humanreadabledatetime($row["session_date"]);
        $data = $row;

    } else {

        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;

    }
}
if (isset($_POST["update_health_tracker_account"])) {
    $ownerid = $authUser["id"];
    $update_weight = $db->real_escape_string($_POST["update_weight"]);
    $update_gender = $db->real_escape_string($_POST["update_gender"]);
    $update_height = $db->real_escape_string($_POST["update_height"]);
    $update_blood_group = $db->real_escape_string($_POST["update_blood_group"]);
    $update_bmi = $db->real_escape_string($_POST["update_bmi"]);
    $update_heart_rate = $db->real_escape_string($_POST["update_heart_rate"]);
    $update_respiratory_rate = $db->real_escape_string($_POST["update_respiratory_rate"]);
    $update_blood_glucose = $db->real_escape_string($_POST["update_blood_glucose"]);
    $update_blood_fasting_glucose = $db->real_escape_string($_POST["update_blood_fasting_glucose"]);
    $update_blood_none_fasting_glucose = $db->real_escape_string($_POST["update_blood_none_fasting_glucose"]);
    $update_alergy = $db->real_escape_string($_POST["update_alergy"]);
    $update_medications = $db->real_escape_string($_POST["update_medications"]);
    $sql = "UPDATE users SET weight='$update_weight', height='$update_height', gender='$update_gender', blood_group='$update_blood_group', bmi='$update_bmi', heart_rate='$update_heart_rate', respiratory_rate='$update_respiratory_rate', blood_glucose='$update_blood_glucose', blood_fasting_glucose='$update_blood_fasting_glucose', blood_none_fasting_glucose='$update_blood_none_fasting_glucose', alergy='$update_alergy', medications='$update_medications' WHERE  id='$ownerid'";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["healthtracker"])) {

}
if (isset($_POST["turnOnDoctor"])) {
    $owner = $authUser["id"];
    $turnOnDoctor = cleanInput($_POST["turnOnDoctor"]);
    if ($authUser["availability"] != "Completing Task") {
        $sql = "UPDATE users SET availability='$turnOnDoctor' WHERE id='$owner'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "Your availability has been turn " . $turnOnDoctor;
            $row["availability"] = $turnOnDoctor;
            $data = $row;
        } else {
            $row["card"] = "green";
            $row["status"] = "fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "green";
        $row["status"] = "fail";
        $row["message"] = "You are in a middle of completing a task";
        $data = $row;
    }

}
if (isset($_POST["viewThiscare"])) {
    $id = cleanInput($_POST["viewThiscare"]);
    $caresql = "SELECT * FROM care WHERE id='$id'";
    $careresult = $db->query($caresql);
    if ($careresult->num_rows > 0) {
        $row = $careresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist<script>window.location.href= ''.$domain.'/404';</script>";
        $data = $row;
    }
}

if (isset($_POST["cancelcarerequest"])) {
    $id = cleanInput($_POST["cancelcarerequest"]);
    $owner = $authUser["id"];
    $sql = "UPDATE care SET request_status='Canceled', WHERE  id='$id' AND requesterid='$owner'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The request has been canceled successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["requestdoctor"])) {
    $ownerid = $authUser["id"];
    $caredate = cleanInput($_POST["caredate"]);
    $caretime = cleanInput($_POST["caretime"]);
    $patientname = cleanInput($_POST["patientname"]);
    $patientproblem = cleanInput($_POST["patientsickness"]);
    $patientaddress = cleanInput($_POST["patientaddress"]);
    $requesterid = $ownerid;
    $lat = cleanInput($_POST["lat"]);
    $lng = cleanInput($_POST["lng"]);
    $caretype = cleanInput($_POST["caretype"]);

    if ($caredate != "" && $caretime != "" && $patientname != "" && $patientproblem != "" && $patientaddress != "" && $requesterid != "") {
        $caresql = "INSERT INTO care (caredate, caretime, patientname, patientproblem, patientaddress, requesterid, lat, lng, request_status, caretype)
		VALUES ('$caredate', '$caretime', '$patientname', '$patientproblem', '$patientaddress', '$requesterid', '$lat', '$lng', 'New', '$caretype')";

        if ($db->query($caresql) === TRUE) {

            $row["last_id"] = $db->insert_id;
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "New record successfully created";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["postPrescription"])) {
    define('UPLOAD_DIR', 'prescription/');
    $img1 = $_POST["postPrescription"];
    if (strpos($img1, 'data:image/png;base64,') !== false) {
        $imgtype1 = ".png";
        $img1 = str_replace('data:image/png;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
        $imgtype1 = ".jpg";
        $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    $data1 = base64_decode($img1);
    $namez = rand(100000, 100000000) . uniqid();
    $namez = md5($namez);
    $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
    $success1 = file_put_contents($imgfile1, $data1);
    $imgfileurl1 = $itemurl . $imgfile1;
    $ownerid = $authUser["id"];
    $sql = "INSERT INTO prescriptions (prescribe_by, prescribe_to, valid, image)
	VALUES ('0', '$ownerid', 'waiting', '$imgfileurl1')";
    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Uploaded successfully";
        $data["imgurl"] = $imgfileurl1;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Fail to upload";
        $data["imgurl"] = $imgfileurl1;
    }
}


if (isset($_POST["myPrescription"])) {
    $owner = $authUser["id"];
    $sql = "SELECT * FROM chats WHERE owner_one='$owner' AND paid='true' AND storeapprove='true'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["dr"] = getDoctorFullname($row["owner_two"]);
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "You have no prescription";
        $data = $row;
    }
}
if (isset($_POST["doctorinfo"])) {
    $id = cleanInput($_POST["doctorinfo"]);
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["password"] = "*******";
        $row["login_token"] = "*******";
        $row["phonenumber"] = "*******";
        $sqlr = "SELECT * FROM reviews WHERE to_id='$id'";
        $resultr = $db->query($sqlr);
        $row["review_count"] = $resultr->num_rows;
        $sqlr = "SELECT * FROM chats WHERE owner_one='$id' || owner_two = '$id'";
        $resultr = $db->query($sqlr);
        $row["patient_attended"] = $resultr->num_rows;
        $row["education"] = getUni($id);
        $row["rate"] = getHcRate($row["id"]);
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "This user doesn't exist";
        $data = $row;
    }
}
if (isset($_POST["initiateChatwithfromcart"])) {
    $owner = $authUser["id"];
    $isdoctor = cleanInput($_POST["isdoctor"]);
    $chatwith = cleanInput($_POST["initiateChatwithfromcart"]);
    $doctorearning = getInhouseRate();
    $sickness = cleanInput($_POST["sickness"]);
    $datetiembook = $currentdatetime;
    $bookingtype = cleanInput($_POST["type"]);
    $sql = "SELECT * FROM chats WHERE owner_one='$owner' AND owner_two='$chatwith' AND active='true' AND archive='' OR owner_one='$chatwith' AND owner_two='$owner' AND active='true' AND AND archive=''";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data["status"] = "Successfull";
        $data["chat_id"] = $row["id"];
    } else {
        $sql = "INSERT INTO chats (owner_one, owner_two, active, session_reason, session_date, session_status, type, doctor, doctorearning)
		VALUES ('$owner', '$chatwith', 'true', '$sickness', '$datetiembook', 'new', '$bookingtype', '$isdoctor', '$doctorearning')";
        if ($db->query($sql) === TRUE) {
            $last_id = $db->insert_id;
            $sqlrem = "DELETE FROM carts WHERE prescription='true' AND owner='$owner'";
            $db->query($sqlrem);
            $sqlcharge = "UPDATE users SET wallet=wallet-$doctorearning WHERE id='$owner'";
            $db->query($sqlcharge);
            /* $sqlgive = "UPDATE users SET wallet=wallet+$price WHERE id='$chatwith'";
			$db->query($sqlgive); */
            $chatdate = date("Y-m-d H:i:s");
            $reason = 'Patient have started a chat session. Reason: ' . $sickness;
            $sqlinsertchat = "INSERT INTO chatcontent (chat_thread, chat_content, owner, chat_date, doctorearning)
			VALUES ('$last_id', '$reason', '0', '$chatdate')";
            $db->query($sqlinsertchat);
            $data["status"] = "Successfull";
            $data["chat_id"] = $last_id;

        } else {
            $row["status"] = "fail";
            $row["message"] = "Error deleting record: " . $db->error;
            $data = $row;
        }
    }
}
if (isset($_POST["initiateChatwith"])) {
    $owner = $authUser["id"];
    $isdoctor = cleanInput($_POST["isdoctor"]);
    $chatwith = cleanInput($_POST["initiateChatwith"]);
    $doctorearning = cleanInput($_POST["price"]);
    $sickness = cleanInput($_POST["sickness"]);
    $datetiembook = cleanInput($_POST["bookingdate"]);
    $bookingtype = cleanInput($_POST["type"]);
    $sql = "SELECT * FROM chats WHERE owner_one='$owner' AND owner_two='$chatwith' AND active='true' AND archive='' OR owner_one='$chatwith' AND owner_two='$owner' AND active='true' AND AND archive=''";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data["status"] = "Successfull";
        $data["chat_id"] = $row["id"];
    } else {
        $sql = "INSERT INTO chats (owner_one, owner_two, active, session_reason, session_date, session_status, type, doctor, doctorearning)
		VALUES ('$owner', '$chatwith', 'true', '$sickness', '$datetiembook', 'new', '$bookingtype', '$isdoctor', '$doctorearning')";
        if ($db->query($sql) === TRUE) {
            $last_id = $db->insert_id;
            $sqlcharge = "UPDATE users SET wallet=wallet-$doctorearning WHERE id='$owner'";
            $db->query($sqlcharge);
            /* $sqlgive = "UPDATE users SET wallet=wallet+$price WHERE id='$chatwith'";
			$db->query($sqlgive); */
            $chatdate = date("Y-m-d H:i:s");
            $reason = 'Patient have started a chat session. Reason: ' . $sickness;
            $sqlinsertchat = "INSERT INTO chatcontent (chat_thread, chat_content, owner, chat_date)
			VALUES ('$last_id', '$reason', '0', '$chatdate')";
            $db->query($sqlinsertchat);
            $data["status"] = "Successfull";
            $data["chat_id"] = $last_id;

        } else {
            $row["status"] = "fail";
            $row["message"] = "Error deleting record: " . $db->error;
            $data = $row;
        }
    }
}
if (isset($_POST["admincheckneworder"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE order_status='New' OR order_status='Preparing'";
    $result = $db->query($sql);
    $data["new_order_count"] = $result->num_rows;
    $data["status"] = "success";
    $data["message"] = "Request updated";
}
if (isset($_POST["viewalljob_order_past"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE restaurant_id='$uid' AND order_status='Completed' OR restaurant_id='$uid' AND  order_status='Canceled'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row["order_date"] = date("F jS, Y, g:i a", strtotime($row["order_date"]));
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No new order";
        $data = $row;
    }
}


if (isset($_POST["adminsetcompleted"])) {
    $oid = cleanInput($_POST["adminsetcompleted"]);
    $customernnedtopay = cleanInput($_POST["customerneedtopay"]);
    $riderid = cleanInput($_POST["riderid"]);
    $sql = "SELECT * FROM job_order WHERE id='$oid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jid = json_decode($row["data"]);
        $row["job_type"] = $jid->job_type;

        $restaurantid = $row["restaurant_id"];
        $totalpayment = $row["cart_price"];
        $totalpayments = $row["cart_price"];
        $currentorderpromo = $row["promo"];
        $checkDeliveryprice = $row["delivery_price"];

        $companyprofit = 15 * $totalpayment / 100;
        $totalpayment = $totalpayment - $companyprofit;
        $orderowner = $row["owner"];
        if ($row["payment_type"] == "COD") {
            //COD START HERE
            if ($row["job_type"] == "Parcel Delivery") {
                $deliveryprice = $row["cart_price"];
                $companyprofit = 20 * $deliveryprice / 100;
                $credittoremove = $deliveryprice - $companyprofit;
                $sql1 = "UPDATE users SET rider_credit=rider_credit-$credittoremove WHERE id='$riderid'";
            } else {
                $sql1 = "UPDATE users SET rider_credit=rider_credit-$totalpayments WHERE id='$riderid'";
            }

            if ($db->query($sql1) === TRUE) {
                $sql2 = "UPDATE users SET wallet=wallet+$totalpayment WHERE id='$restaurantid'";
                if ($db->query($sql2) === TRUE) {
                    $sql3 = "UPDATE job_order SET order_status='Completed' WHERE id='$oid' ";
                    if ($db->query($sql3) === TRUE) {
                        $NewpromotionPercentage = $row["promo"];
                        $NewcurrentdeliveryPrice = $row["delivery_price"];

                        if ($NewcurrentdeliveryPrice < 5) {
                            if ($NewpromotionPercentage > 0) {
                                $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                                $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = 5 - $customerpay;
                            } else {
                                $topayrider = 5;
                                $customerpay = $NewcurrentdeliveryPrice;
                                $companyadd = $topayrider - $NewcurrentdeliveryPrice;
                            }
                        } elseif ($NewcurrentdeliveryPrice >= 5) {
                            if ($NewpromotionPercentage > 0) {
                                $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                                $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = $NewcurrentdeliveryPrice - $customerpay;
                            } else {
                                $customerpay = $NewcurrentdeliveryPrice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = 0;
                            }
                        }
                        if ($companyadd == 0) {
                            $sql4 = "UPDATE users SET availability='On' WHERE id='$riderid'";
                        } else {
                            $sql4 = "UPDATE users SET availability='On', wallet=wallet+'$companyadd' WHERE id='$riderid'";
                        }


                        if ($db->query($sql4) === TRUE) {
                            $row["card"] = "green";
                            $row["status"] = "Successfull";
                            $row["message"] = "You have completed this order";
                            $row["order_status"] = "Completed";
                            $data = $row;
                        } else {
                            $row["card"] = "red";
                            $row["status"] = "Fail";
                            $row["message"] = "Error updating record: " . $db->error;
                            $data = $row;
                        }

                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error updating record: " . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
            //COD END HERE
        } else {

            $jobdata = $row["data"];
            $scramble = json_decode($jobdata);
            $deliveryprice = $row["delivery_price"];
            $totalpayment = $row["cart_price"];
            $companyprofit = 15 * $totalpayment / 100;
            $totalpayment = $totalpayment - $companyprofit;
            $customerid = $row["owner"];
            $restaurantprofit = $row["restaurant_profit"];
            $NewpromotionPercentage = $row["promo"];
            $NewcurrentdeliveryPrice = $row["delivery_price"];

            if ($NewcurrentdeliveryPrice < 5) {
                $deliveryprice = 5;
            } elseif ($NewcurrentdeliveryPrice >= 5) {
                if ($NewpromotionPercentage > 0) {
                    $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                    $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                    $riderget = $customerpay - $NewcurrentdeliveryPrice;
                    $companyadd = $NewcurrentdeliveryPrice - $customerpay;
                } else {
                    $customerpay = $NewcurrentdeliveryPrice;
                    $riderget = $customerpay - $NewcurrentdeliveryPrice;
                    $companyadd = 0;
                }
            }
            if ($row["payment_type"] == "Online") {
                $customernnedtopay = 0.00;
            }
            $sql1 = "UPDATE users SET wallet=wallet+$deliveryprice WHERE id='$riderid'";
            if ($db->query($sql1) === TRUE) {
                $sql2 = "UPDATE users SET wallet=wallet+$restaurantprofit WHERE id='$restaurantid'";
                if ($db->query($sql2) === TRUE) {
                    $sql3 = "UPDATE job_order SET order_status='Completed' WHERE id='$oid' ";
                    if ($db->query($sql3) === TRUE) {
                        $sql4 = "UPDATE users SET availability='On' WHERE id='$riderid'";
                        if ($db->query($sql4) === TRUE) {

                            $sqlcus = "UPDATE users SET wallet=wallet-$customernnedtopay WHERE id='$customerid'";
                            $db->query($sqlcus);

                            $row["card"] = "green";
                            $row["status"] = "Successfull";
                            $row["message"] = "You have completed this order";
                            $row["order_status"] = "Completed";
                            $data = $row;
                        } else {
                            $row["card"] = "red";
                            $row["status"] = "Fail";
                            $row["message"] = "4.Error updating record: " . $db->error;
                            $data = $row;
                        }

                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "3. Error updating record: " . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "2. Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "1. Error updating record: " . $db->error;
                $data = $row;
            }

        }


    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }

}
header('Access-Control-Allow-Origin: *');
if (isset($_POST["settlementconfirm"])) {
    $owner = cleanInput($_POST["settlementconfirm"]);
    $total = cleanInput($_POST["settlementtotal"]);
    $title = 'Your balance has been transfered';
    $title_my = 'Your balance has been transfered';
    $description = 'Your wallet balance RM' . $total . ' has been transfered to your bank account. This process will take 24-48 hour. Thank you for being a part of our family.';
    $description_my = 'Your wallet balance RM' . $total . ' has been transfered to your bank account. This process will take 24-48 hour. Thank you for being a part of our family.';

    $sql = "UPDATE users SET wallet=wallet -$total WHERE  id='$owner' ";

    if ($db->query($sql) === TRUE) {
        if ($title != "" && $title_my != "" && $description != "" && $description_my != "" && $owner != "") {
            $notifcationssql = "INSERT INTO notifcations (title, title_my, description, description_my, owner)
			VALUES ('$title', '$title_my', '$description', '$description_my', '$owner')";

            if ($db->query($notifcationssql) === TRUE) {
                $row["card"] = "green";
                $row["status"] = "Successful";
                $row["message"] = "Settlement has been marked complete. Notification has been sent to the user";
                $data = $row;
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                $data = $row;
            }
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }

}
if (isset($_POST["switchrider"])) {
    $orderid = cleanInput($_POST["switchrider"]);
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    $sqlrun = "SELECT *, ( 6371 * acos( cos( radians('$first_restaurant_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$first_restaurant_lng') ) + sin( radians('$first_restaurant_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM users WHERE type ='2' AND availability='On' GROUP BY distance HAVING distance < 5 ORDER BY distance ASC LIMIT 0,1";
    $runresult = $db->query($sqlrun);
    if ($runresult->num_rows > 0) {
        $riderselected = 0;
        while ($runner = $runresult->fetch_assoc()) {
            if ($riderselected == 0) {
                $riderselected++;
                $riderid = $runner["id"];
                $sql = "UPDATE job_order SET runner='$riderid' WHERE id='$orderid'";
                if ($db->query($sql) === TRUE) {
                    $row["card"] = "red";
                    $row["status"] = "Success";
                    $row["message"] = "Rider has been switched";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Server Error. Please try again";
                    $data = $row;
                }
            }
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "There is no rider available";
        $data = $row;
    }
}
//New Admin Update
if (isset($_POST["adminupdateuser"])) {
    $id = cleanInput($_POST["adminupdateuser"]);
    $firstname = cleanInput($_POST["firstname"]);
    $lastname = cleanInput($_POST["lastname"]);
    $email = cleanInput($_POST["email"]);
    $credit = cleanInput($_POST["credit"]);
    $wallet = cleanInput($_POST["wallet"]);
    $type = cleanInput($_POST["type"]);
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', wallet='$wallet', rider_credit='$credit', type='$type' WHERE id='$id'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "red";
        $row["status"] = "Success";
        $row["message"] = "You have successfully updated this user information";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Fail to update. Please try again";
        $data = $row;
    }

}
//New Update
if (isset($_POST["processordercard"])) {
    $row["card"] = "green";
    $row["status"] = "fail";
    $row["message"] = "This payment method is still under development and it will be activated soon.";
    $data = $row;
}
if (isset($_POST["inserttocard"])) {
    $row["card"] = "green";
    $row["status"] = "fail";
    $row["message"] = "This payment method is still under development";
    $data = $row;
}
if (isset($_POST["setcardprimary"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["setcardprimary"]);
    $sql = "UPDATE cardtoken SET primarycard='false' WHERE  owner='$owner'";
    if ($db->query($sql) === TRUE) {
        $sql = "UPDATE cardtoken SET primarycard='true' WHERE  id='$id'";

        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["deleteFromcardtoken"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["deleteFromcardtoken"]);
    $sql = "DELETE FROM cardtoken WHERE id='$id' AND owner='$owner'";
    if ($db->query($sql) === TRUE) {
        $row["status"] = "success";
        $row["message"] = 'The card has been deleted successfully';
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Error deleting record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["viewallmycard"])) {
    $id = $authUser["id"];
    $sql = "SELECT * FROM cardtoken WHERE owner='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["approveestablishement"])) {
    $userid = cleanInput($_POST["approveestablishement"]);
    $sql = "UPDATE users SET availability='Off' WHERE  id='$userid'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successful";
        $row["message"] = "The record has been updated successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["approveuser"])) {
    $approval = cleanInput($_POST["reviewresult"]);
    $userid = cleanInput($_POST["approveuser"]);
    $applicationid = cleanInput($_POST["applicationid"]);
    if ($approval == "On") {
        $sql = "UPDATE users SET availability='On', rider_approved='true' WHERE  id='$userid'";
        if ($db->query($sql) === TRUE) {
            $sql = "UPDATE rider_activations SET status='true' WHERE id='$applicationid'";
            if ($db->query($sql) === TRUE) {

            }
            $sqlas = "INSERT INTO notifcations (
			title, 
			title_my, 
			description, 
			description_my, 
			owner)
			VALUES ('You rider account has been activated', 
			'You rider account has been activated', 
			'Hello and welcome to the family. Your account has been activated. Please top up your credit to recieve delivery request', 
			'Hello and welcome to the family. Your account has been activated. Please top up your credit to recieve delivery request', '$userid')";

            if ($db->query($sqlas) === TRUE) {

            } else {

            }
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $sqlas = "INSERT INTO notifcations (
			title, 
			title_my, 
			description, 
			description_my, 
			owner)
			VALUES (
			'Activation Declined', 
			'Activation Declined', 
			'Hello your account activation request has been decline. Please send a proper document.', 
			'Hello your account activation request has been decline. Please send a proper document.', '$userid')";

        if ($db->query($sqlas) === TRUE) {
            echo 'Success';
        } else {
            echo "Error updating record: " . $db->error;
        }
        $sql = "UPDATE rider_documents SET approved='Fail' WHERE id='$applicationid'";

        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successfull";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    }
}
if (isset($_POST["viewThisrider_documents"])) {
    $id = $authUser["id"];
    $rider_documentssql = "SELECT * FROM rider_documents WHERE user_id='$id'";
    $rider_documentsresult = $db->query($rider_documentssql);
    if ($rider_documentsresult->num_rows > 0) {
        $row = $rider_documentsresult->fetch_assoc();
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["inserttorider_documents"])) {
    $cansubmit = false;
    $user_id = $authUser["id"];
    $ic = cleanInput($_POST["ic"]);
    $lisence = cleanInput($_POST["lisence"]);
    $rider_documentssql = "SELECT * FROM rider_documents WHERE user_id='$user_id'";
    $rider_documentsresult = $db->query($rider_documentssql);
    if ($rider_documentsresult->num_rows > 0) {
        $row = $rider_documentsresult->fetch_assoc();

        $prevsub = $row["user_id"];
        $sqlz = "DELETE FROM rider_documents WHERE user_id='$user_id'";

        if ($db->query($sqlz) === TRUE) {
            $cansubmit = true;
            if ($user_id != "" && $ic != "" && $lisence != "" && $cansubmit == true) {
                define('UPLOAD_DIR', 'assets/');
                $img1 = $_POST["ic"];

                if (strpos($img1, 'data:image/png;base64,') !== false) {
                    $imgtype1 = ".png";
                    $img1 = str_replace('data:image/png;base64,', '', $img1);
                    $img1 = str_replace(' ', '+', $img1);
                }
                if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
                    $imgtype1 = ".jpg";
                    $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
                    $img1 = str_replace(' ', '+', $img1);
                }
                $data1 = base64_decode($img1);
                $namez = rand(100000, 100000000) . uniqid();
                $namez = md5($namez);
                $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
                $success1 = file_put_contents($imgfile1, $data1);

                $imgfileurl1 = $itemurl . $imgfile1;
                $ic = cleanInput($imgfileurl1);

                $img2 = $_POST["lisence"];
                if (strpos($img2, 'data:image/png;base64,') !== false) {
                    $imgtype2 = ".png";
                    $img2 = str_replace('data:image/png;base64,', '', $img2);
                    $img2 = str_replace(' ', '+', $img2);
                }
                if (strpos($img2, 'data:image/jpeg;base64,') !== false) {
                    $imgtype2 = ".jpg";
                    $img2 = str_replace('data:image/jpeg;base64,', '', $img2);
                    $img2 = str_replace(' ', '+', $img2);
                }
                $data2 = base64_decode($img2);
                $namez2 = rand(100000, 100000000) . uniqid() . rand(100000, 999999999);
                $namez2 = md5($namez2);
                $imgfile2 = UPLOAD_DIR . uniqid() . $namez2 . $imgtype2;
                $success2 = file_put_contents($imgfile2, $data2);

                $imgfileurl2 = $itemurl . $imgfile2;
                $lisence = cleanInput($imgfileurl2);
                $rider_documentssql = "INSERT INTO rider_documents (user_id, ic, lisence, approved)
		VALUES ('$user_id', '$ic', '$lisence', 'waiting')";

                if ($db->query($rider_documentssql) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successful";
                    $row["message"] = "Your request has been submitted succesfully";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Please fill all the form";
                $data = $row;
            }
        } else {
            $cansubmit = false;
        }

    } else {
        $cansubmit = true;
        if ($user_id != "" && $ic != "" && $lisence != "" && $cansubmit == true) {
            define('UPLOAD_DIR', 'assets/');
            $img1 = $_POST["ic"];

            if (strpos($img1, 'data:image/png;base64,') !== false) {
                $imgtype1 = ".png";
                $img1 = str_replace('data:image/png;base64,', '', $img1);
                $img1 = str_replace(' ', '+', $img1);
            }
            if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
                $imgtype1 = ".jpg";
                $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
                $img1 = str_replace(' ', '+', $img1);
            }
            $data1 = base64_decode($img1);
            $namez = rand(100000, 100000000) . uniqid();
            $namez = md5($namez);
            $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
            $success1 = file_put_contents($imgfile1, $data1);

            $imgfileurl1 = $itemurl . $imgfile1;
            $ic = cleanInput($imgfileurl1);

            $img2 = $_POST["lisence"];
            if (strpos($img2, 'data:image/png;base64,') !== false) {
                $imgtype2 = ".png";
                $img2 = str_replace('data:image/png;base64,', '', $img2);
                $img2 = str_replace(' ', '+', $img2);
            }
            if (strpos($img2, 'data:image/jpeg;base64,') !== false) {
                $imgtype2 = ".jpg";
                $img2 = str_replace('data:image/jpeg;base64,', '', $img2);
                $img2 = str_replace(' ', '+', $img2);
            }
            $data2 = base64_decode($img2);
            $namez2 = rand(100000, 100000000) . uniqid() . rand(100000, 999999999);
            $namez2 = md5($namez2);
            $imgfile2 = UPLOAD_DIR . uniqid() . $namez2 . $imgtype2;
            $success2 = file_put_contents($imgfile2, $data2);

            $imgfileurl2 = $itemurl . $imgfile2;
            $lisence = cleanInput($imgfileurl2);
            $rider_documentssql = "INSERT INTO rider_documents (user_id, ic, lisence, approved)
		VALUES ('$user_id', '$ic', '$lisence', 'waiting')";

            if ($db->query($rider_documentssql) === TRUE) {
                $row["card"] = "green";
                $row["status"] = "Successful";
                $row["message"] = "Your request has been submitted succesfully";
                $data = $row;
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                $data = $row;
            }
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    }


}


if (isset($_POST["productavailability"])) {
    $id = cleanInput($_POST["productavailability"]);
    $available = cleanInput($_POST["editavailable"]);

    $sql = "UPDATE products SET available='$available' WHERE  id='$id' ";

    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successful";
        $row["message"] = "This product availability has been turn " . $available;
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}


if (isset($_POST["viewThisusers"])) {
    $id = cleanInput($_POST["viewThisusers"]);
    $userssql = "SELECT * FROM users WHERE id='$id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row = $usersresult->fetch_assoc();
        $productowner = $row["id"];
        if ($row["type"] == 1) {
            $sqlx = "SELECT * FROM products WHERE owner = '$productowner'";
            $resultx = $db->query($sqlx);

            if ($resultx->num_rows > 0) {
                // output data of each row
                while ($rowx = $resultx->fetch_assoc()) {
                    $product[] = $rowx;
                }
                $row["products"] = $product;
            } else {

            }
        }
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}
if (isset($_POST["requestDelivery"])) {
    $owner = $authUser["id"];
    $sql = "SELECT * FROM users WHERE rider_credit > '0.00' AND availability='On'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $runnerid = $row["id"];
        $restaurant_id = cleanInput($_POST["restaurant_id"]);
        $data = cleanInput($_POST["data"]);
        $order_date = $currentdatetime;
        $order_status = cleanInput($_POST["order_status"]);
        $runner = $runnerid;
        $payment_type = cleanInput($_POST["payment_type"]);
        $cart_price = cleanInput($_POST["cart_price"]);

        if ($owner != "" && $restaurant_id != "" && $data != "" && $order_date != "" && $order_status != "" && $runner != "" && $payment_type != "" && $cart_price != "") {
            $job_ordersql = "INSERT INTO job_order (owner, restaurant_id, data, order_date, order_status, runner, payment_type, cart_price, delivery_price)
		VALUES ('$owner', '$restaurant_id', '$data', '$order_date', '$order_status', '$runner', '$payment_type', '$cart_price', '$cart_price')";

            if ($db->query($job_ordersql) === TRUE) {
                $last_id = $db->insert_id;
                $sqlos = "UPDATE users SET availability='Completing Task' WHERE  id='$runnerid' ";

                if ($db->query($sqlos) === TRUE) {
                    $row["card"] = "green";
                    $row["status"] = "Successful";
                    $row["message"] = "Your delivery request has been received";
                    $row["order_id"] = $last_id;
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["status"] = "fail";
                $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "There is no active Rider at the moment. Please try again later. ";
        $data = $row;
    }
}

if (isset($_POST["speedycomplete"])) {
    $orderid = cleanInput($_POST["speedycomplete"]);
    $sql = "SELECT * FROM job_order WHERE id ='$orderid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $restaurantid = $row["restaurant_id"];
        $restaurant_profit = $row["restaurant_profit"];
        $order_cost = $row["cart_price"];
        $delivery_cost = $row["delivery_price"];
        $customerid = $row["owner"];
        $minusfromcustomerwallet = $order_cost + $delivery_cost;
        if ($row["payment_type"] == "Online") {
            $sqlcustomer = "UPDATE users SET wallet=wallet WHERE id='$customerid'";
        } elseif ($row["payment_type"] == "Wallet") {
            $sqlcustomer = "UPDATE users SET wallet=wallet-'$minusfromcustomerwallet' WHERE id='$customerid'";
        }

        if ($db->query($sqlcustomer) === TRUE) {
            $sqlrestaurant = "UPDATE users SET wallet=wallet+'$restaurant_profit' WHERE id='$restaurantid'";
            if ($db->query($sqlrestaurant) === TRUE) {
                $sqlorder = "UPDATE job_order SET order_status='Completed' WHERE id='$orderid'";
                if ($db->query($sqlorder) === TRUE) {
                    $row["card"] = "red";
                    $row["status"] = "Success";
                    $row["message"] = "This order has been completed";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            }
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Order not found";
        $data = $row;
    }
}

if (isset($_POST["runnersetcompleted"])) {
    $oid = cleanInput($_POST["runnersetcompleted"]);
    $customernnedtopay = cleanInput($_POST["customerneedtopay"]);
    $riderid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE id='$oid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $jid = json_decode($row["data"]);
        $row["job_type"] = $jid->job_type;

        $restaurantid = $row["restaurant_id"];
        $totalpayment = $row["cart_price"];
        $totalpayments = $row["cart_price"];
        $currentorderpromo = $row["promo"];
        $checkDeliveryprice = $row["delivery_price"];

        $companyprofit = 15 * $totalpayment / 100;
        $totalpayment = $totalpayment - $companyprofit;
        $orderowner = $row["owner"];
        if ($row["payment_type"] == "COD") {
            //COD START HERE
            if ($row["job_type"] == "Parcel Delivery") {
                $deliveryprice = $row["cart_price"];
                $companyprofit = 20 * $deliveryprice / 100;
                $credittoremove = $deliveryprice - $companyprofit;
                $sql1 = "UPDATE users SET rider_credit=rider_credit-$credittoremove WHERE id='$riderid'";
            } else {
                $sql1 = "UPDATE users SET rider_credit=rider_credit-$totalpayments WHERE id='$riderid'";
            }

            if ($db->query($sql1) === TRUE) {
                $sql2 = "UPDATE users SET wallet=wallet+$totalpayment WHERE id='$restaurantid'";
                if ($db->query($sql2) === TRUE) {
                    $sql3 = "UPDATE job_order SET order_status='Completed' WHERE id='$oid' ";
                    if ($db->query($sql3) === TRUE) {
                        $NewpromotionPercentage = $row["promo"];
                        $NewcurrentdeliveryPrice = $row["delivery_price"];

                        if ($NewcurrentdeliveryPrice < 5) {
                            if ($NewpromotionPercentage > 0) {
                                $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                                $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = 5 - $customerpay;
                            } else {
                                $topayrider = 5;
                                $customerpay = $NewcurrentdeliveryPrice;
                                $companyadd = $topayrider - $NewcurrentdeliveryPrice;
                            }
                        } elseif ($NewcurrentdeliveryPrice >= 5) {
                            if ($NewpromotionPercentage > 0) {
                                $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                                $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = $NewcurrentdeliveryPrice - $customerpay;
                            } else {
                                $customerpay = $NewcurrentdeliveryPrice;
                                $riderget = $customerpay - $NewcurrentdeliveryPrice;
                                $companyadd = 0;
                            }
                        }
                        if ($companyadd == 0) {
                            $sql4 = "UPDATE users SET availability='On' WHERE id='$riderid'";
                        } else {
                            $sql4 = "UPDATE users SET availability='On', wallet=wallet+'$companyadd' WHERE id='$riderid'";
                        }


                        if ($db->query($sql4) === TRUE) {
                            $row["card"] = "green";
                            $row["status"] = "Successfull";
                            $row["message"] = "You have completed this order";
                            $row["order_status"] = "Completed";
                            $data = $row;
                        } else {
                            $row["card"] = "red";
                            $row["status"] = "Fail";
                            $row["message"] = "Error updating record: " . $db->error;
                            $data = $row;
                        }

                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "Error updating record: " . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error updating record: " . $db->error;
                $data = $row;
            }
            //COD END HERE
        } else {

            $jobdata = $row["data"];
            $scramble = json_decode($jobdata);
            $deliveryprice = $row["delivery_price"];
            $totalpayment = $row["cart_price"];
            $companyprofit = 15 * $totalpayment / 100;
            $totalpayment = $totalpayment - $companyprofit;
            $customerid = $row["owner"];
            $restaurantprofit = $row["restaurant_profit"];
            $NewpromotionPercentage = $row["promo"];
            $NewcurrentdeliveryPrice = $row["delivery_price"];

            if ($NewcurrentdeliveryPrice < 5) {
                $deliveryprice = 5;
            } elseif ($NewcurrentdeliveryPrice >= 5) {
                if ($NewpromotionPercentage > 0) {
                    $promotionprice = $NewpromotionPercentage * $NewcurrentdeliveryPrice / 100;
                    $customerpay = $NewcurrentdeliveryPrice - $promotionprice;
                    $riderget = $customerpay - $NewcurrentdeliveryPrice;
                    $companyadd = $NewcurrentdeliveryPrice - $customerpay;
                } else {
                    $customerpay = $NewcurrentdeliveryPrice;
                    $riderget = $customerpay - $NewcurrentdeliveryPrice;
                    $companyadd = 0;
                }
            }
            if ($row["payment_type"] == "Online") {
                $customernnedtopay = 0.00;
            }
            $sql1 = "UPDATE users SET wallet=wallet+$deliveryprice WHERE id='$riderid'";
            if ($db->query($sql1) === TRUE) {
                $sql2 = "UPDATE users SET wallet=wallet+$restaurantprofit WHERE id='$restaurantid'";
                if ($db->query($sql2) === TRUE) {
                    $sql3 = "UPDATE job_order SET order_status='Completed' WHERE id='$oid' ";
                    if ($db->query($sql3) === TRUE) {
                        $sql4 = "UPDATE users SET availability='On' WHERE id='$riderid'";
                        if ($db->query($sql4) === TRUE) {

                            $sqlcus = "UPDATE users SET wallet=wallet-$customernnedtopay WHERE id='$customerid'";
                            $db->query($sqlcus);

                            $row["card"] = "green";
                            $row["status"] = "Successfull";
                            $row["message"] = "You have completed this order";
                            $row["order_status"] = "Completed";
                            $data = $row;
                        } else {
                            $row["card"] = "red";
                            $row["status"] = "Fail";
                            $row["message"] = "4.Error updating record: " . $db->error;
                            $data = $row;
                        }

                    } else {
                        $row["card"] = "red";
                        $row["status"] = "Fail";
                        $row["message"] = "3. Error updating record: " . $db->error;
                        $data = $row;
                    }
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "2. Error updating record: " . $db->error;
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "1. Error updating record: " . $db->error;
                $data = $row;
            }

        }


    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }

}
if (isset($_POST["creditusers"])) {
    $owner = $authUser["id"];
    $sql = "SELECT rider_credit FROM users WHERE id='$owner'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["status"] = "success";
        $row["message"] = "Data available";
        $data = $row;

    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["inserttowithdrawal_requests"])) {
    $user_id = $authUser["id"];
    $bank_name = cleanInput($_POST["bank_name"]);
    $bank_account_number = cleanInput($_POST["bank_account_number"]);
    $amount = cleanInput($_POST["amount"]);
    $request_date = date("Y-m-d H:i:s");

    if ($user_id != "" && $bank_name != "" && $bank_account_number != "" && $amount != "" && $request_date != "") {
        $withdrawal_requestssql = "INSERT INTO withdrawal_requests (user_id, bank_name, bank_account_number, amount, request_date)
		VALUES ('$user_id', '$bank_name', '$bank_account_number', '$amount', '$request_date')";

        if ($db->query($withdrawal_requestssql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "Your wallet withdrwal request has been received.";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please complete your bank account information in setting";
        $data = $row;
    }
}
if (isset($_POST["requesttopupsession"])) {
    $userid = $authUser["id"];
    $amount = $db->real_escape_string($_POST["requesttopupsession"]);
    $fullname = $authUser["firstname"] . ' ' . $authUser["lastname"];
    $email = $authUser["email"];
    $phone_number = $authUser["phonenumber"];
    $type = $db->real_escape_string($_POST["topuptype"]);
    $sessiondate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type, senang_date)
	VALUES ('$userid', '$amount', 'waiting', '$phone_number', '$email', '$fullname', '$type', '$sessiondate')";
    if ($db->query($sql) === TRUE) {
        $last_id = $db->insert_id;
        $data["status"] = "success";
        $data["message"] = "Session requested successfully";
        $data["orderid"] = $last_id;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Error: " . $sql . "<br>" . $db->error;
    }
}

if (isset($_POST["topUpHistory"])) {
    $userid = $authUser["id"];
    $sql = "SELECT * FROM senangpay WHERE user_id= 29";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_all(MYSQLI_ASSOC);
        $data["data"] = $row;
        $data["status"] = "success";
    } else {
        $data["message"] = "No History found";
        $data["status"] = "Fail";
    }

}

if (isset($_POST["requesttopupsessioniou"])) {
    $userid = $authUser["id"];
    $requestddate = date('Y-m-d H:i:s');
    $userid = $authUser["id"];
    $amount = $db->real_escape_string($_POST["requesttopupsessioniou"]);
    $ioupayrequestsql = "INSERT INTO ioupayrequest (requestddate, owner, amount, status)VALUES ('$requestddate', '$userid', '$amount', 'Waiting')";
    if ($db->query($ioupayrequestsql) === TRUE) {
        $last_id = $db->insert_id;
        $data["status"] = "success";
        $data["message"] = "Session requested successfully";
        $data["orderid"] = $last_id;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
        $data = $row;
    }
}
if (isset($_POST["walletusers"])) {
    $owner = $authUser["id"];
    $sql = "SELECT wallet FROM users WHERE id='$owner'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["status"] = "success";
        $row["message"] = "Data available";
        $sqle = "SELECT * FROM transaction_history WHERE from_user='$owner' OR to_user='$owner' ORDER BY id DESC";
        $resulte = $db->query($sqle);
        if ($resulte->num_rows > 0) {

            while ($rowe = $resulte->fetch_assoc()) {
                $rowe["transaction_date"] = date("F jS, Y", strtotime($rowe["transaction_date"]));
                $transaction_history[] = $rowe;
            }
        } else {
            $transaction_history = "Empty";
        }
        $row["transaction_history"] = $transaction_history;
        $data = $row;

    } else {
        $row["transaction_history"] = "Empty";
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["searchhp"])) {
    $terms = cleanInput($_POST["searchhp"]);
    $category = cleanInput($_POST["getmart"]);
    $user_latitude = cleanInput($_POST["lat"]);
    $user_longitude = cleanInput($_POST["lng"]);
    $sql = "SELECT id, firstname, lastname, rate, category, language, residency, profile_img, lat, lng, availability, provider_type FROM users WHERE firstname LIKE '%$terms%', provider_type ='$category' AND verified_service_provider='Approved'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userLat = $row["lat"];
            $UserLng = $row["lng"];
            $unit = "KM";
            $row["userlat"] = $user_latitude;
            $row["userlng"] = $user_longitude;
            $unitz = "K";
            $row["firstname"] = strtoupper($row["firstname"]);
            $row["rate"] = 10.00;
            $row["lastname"] = strtoupper($row["lastname"]);
            $row["fullname"] = $row["firstname"] . ' ' . $row["lastname"];
            $row["fullname"] = truncateString($row["fullname"], 20, false);
            $row["distance"] = getDistance($user_latitude, $user_longitude, $userLat, $UserLng, $unitz);

            $docid = $row["id"];
            $row["education_place"] = getUni($docid);
            $sqlsession = "SELECT * FROM chats WHERE active='true' AND owner_one='$docid' AND owner_two='$uid' AND archive='' OR active='true' AND owner_one ='$uid' AND owner_two ='$docid' AND archive=''";
            $resultsession = $db->query($sqlsession);

            if ($resultsession->num_rows > 0) {
                $rowsession = $resultsession->fetch_assoc();
                $row["has_session"] = "true";
                $row["session_id"] = $rowsession["id"];
            } else {
                $row["has_session"] = "false";
                $row["session_id"] = "0";
            }
            if ($row["distance"] > 20) {
                $far = false;
            } else {
                $far = false;
            }
            if ($far != true) {
                $data[] = $row;
            }
        }

    } else {
        $row["status"] = "fail";
        $row["message"] = "Empty";
        $data = $row;
    }
}
if (isset($_POST["getmart"])) {
    $uid = $authUser["id"];
    $category = cleanInput($_POST["getmart"]);
    $user_latitude = cleanInput($_POST["lat"]);
    $user_longitude = cleanInput($_POST["lng"]);
    if ($category == "undefined" || $category == "All") {
        $sql = "SELECT id, firstname, lastname, rate, category, language, residency, profile_img, lat, lng, availability, provider_type FROM users WHERE type='6' AND verified_service_provider='Approved' AND provider_type != 'Pharmacist'";
    } else {
        if ($category == "Doctor") {
            $speciality = cleanInput($_POST["speciality"]);
            if ($speciality == "All") {
                $sql = "SELECT id, firstname, lastname, rate, category, language, residency, profile_img, lat, lng, availability, provider_type FROM users WHERE provider_type ='$category' AND verified_service_provider='Approved'";
            } else {
                $sql = "SELECT id, firstname, lastname, rate, category, language, residency, profile_img, lat, lng, availability, provider_type, specialist FROM users WHERE provider_type ='$category' AND verified_service_provider='Approved' AND specialist LIKE '%$speciality%'";
            }
        } else {
            $sql = "SELECT id, firstname, lastname, rate, category, language, residency, profile_img, lat, lng, availability, provider_type FROM users WHERE provider_type ='$category' AND verified_service_provider='Approved'";
        }
    }


    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userLat = $row["lat"];
            $UserLng = $row["lng"];
            $unit = "KM";
            $row["userlat"] = $user_latitude;
            $row["userlng"] = $user_longitude;
            $unitz = "K";
            $row["firstname"] = strtoupper($row["firstname"]);
            $row["rate"] = getHcRate($row["id"]);
            $row["lastname"] = strtoupper($row["lastname"]);
            $row["fullname"] = $row["firstname"] . ' ' . $row["lastname"];
            $row["fullname"] = truncateString($row["fullname"], 20, false);
            $row["distance"] = getDistance($user_latitude, $user_longitude, $userLat, $UserLng, $unitz);

            $docid = $row["id"];
            $row["education_place"] = getUni($docid);
            $sqlsession = "SELECT * FROM chats WHERE active='true' AND owner_one='$docid' AND owner_two='$uid' AND archive='' OR active='true' AND owner_one ='$uid' AND owner_two ='$docid' AND archive=''";
            $resultsession = $db->query($sqlsession);

            if ($resultsession->num_rows > 0) {
                $rowsession = $resultsession->fetch_assoc();
                $row["has_session"] = "true";
                $row["session_id"] = $rowsession["id"];
            } else {
                $row["has_session"] = "false";
                $row["session_id"] = "0";
            }
            if ($row["distance"] > 20) {
                $far = false;
            } else {
                $far = false;
            }
            if ($far != true) {
                $data[] = $row;
            }
        }

    } else {
        $row["status"] = "fail";
        $row["message"] = "Empty";
        $data = $row;
    }
}
if (isset($_POST["deleteFromproducts"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["deleteFromproducts"]);
    $sql = "DELETE FROM products WHERE id='$id' AND owner='$owner'";
    if ($db->query($sql) === TRUE) {
        $row["status"] = "success";
        $row["message"] = 'The menu has been deleted successfully';
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Error deleting record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["updatemenu"])) {
    $uid = $authUser["id"];
    $id = cleanInput($_POST["updatemenu"]);
    $name = cleanInput($_POST["product_name"]);
    $description = cleanInput($_POST["product_description"]);
    $price = cleanInput($_POST["vappyprice"]);
    $originalprice = cleanInput($_POST["originalprice"]);
    $addondata = cleanInput($_POST["addondata"]);
    if ($id != "" && $name != "" && $description != "" && $price != "") {
        $sql = "UPDATE products SET name='$name', description='$description', price='$price', originalprice='$originalprice', addondata='$addondata' WHERE  id='$id' AND owner='$uid'";
        if ($db->query($sql) === TRUE) {
            $row["card"] = "green";
            $row["status"] = "Success";
            $row["message"] = "The record has been updated successfully";
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error updating record: " . $db->error;
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["current_order"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE restaurant_id='$uid' AND order_status='New' OR restaurant_id='$uid' AND order_status='Preparing' OR restaurant_id='$uid' AND order_status='Delivering'";
    $result = $db->query($sql);
    $data["new_order_count"] = $result->num_rows;
    $data["status"] = "success";
    $data["message"] = "Request updated";
}
if (isset($_POST["viewalljob_order_past"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE restaurant_id='$uid' AND order_status='Completed' OR restaurant_id='$uid' AND  order_status='Canceled'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row["order_date"] = date("F jS, Y, g:i a", strtotime($row["order_date"]));
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No new order";
        $data = $row;
    }
}
if (isset($_POST["update_restaurant_account"])) {
    $ownerid = $authUser["id"];
    $firstname = $db->real_escape_string($_POST["update_firstname"]);
    $lastname = $db->real_escape_string($_POST["update_lastname"]);
    $phonenumber = $db->real_escape_string($_POST["update_phonenumber"]);
    $restaurantname = $db->real_escape_string($_POST["update_restaurantname"]);
    $restaurantaddress = $db->real_escape_string($_POST["update_restaurantaddress"]);
    $restaurantopentime = $db->real_escape_string($_POST["update_restaurant_open_time"]);
    $restaurantclosetime = $db->real_escape_string($_POST["update_restaurant_close_time"]);
    $restaurantbankname = $db->real_escape_string($_POST["update_bank_name"]);
    $restaurantaccountnumber = $db->real_escape_string($_POST["update_account_number"]);
    $restaurantlat = $db->real_escape_string($_POST["update_restaurant_lat"]);
    $restaurantlng = $db->real_escape_string($_POST["update_restaurant_lng"]);
    $vendor_halal = $db->real_escape_string($_POST["vendor_halal"]);
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', vendor_name='$restaurantname', vendor_address='$restaurantaddress', vendor_open_time='$restaurantopentime', vendor_close_time='$restaurantclosetime', bank_name='$restaurantbankname', bank_account_number='$restaurantaccountnumber', lat='$restaurantlat', lng='$restaurantlng', vendor_halal='$vendor_halal' WHERE id='$ownerid'";

    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Account updated successfully";
        $data["firstname"] = $firstname;
        $data["lastname"] = $lastname;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Please try again later";
    }
}
if (isset($_POST["setorderpreparing"])) {
    $id = cleanInput($_POST["setorderpreparing"]);

    $sql = "SELECT * FROM job_order WHERE id='$id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["order_status"] == "Delivering") {
            $row["card"] = "red";
            $row["status"] = "Success";
            $row["message"] = "The rider is on the way to pick up and deliverying this order";
            $data = $row;
        } elseif ($row["order_status"] == "New") {
            $sql = "UPDATE job_order SET order_status='Preparing' WHERE id='$id'";
            if ($db->query($sql) === TRUE) {
                $row["card"] = "red";
                $row["status"] = "Success";
                $row["message"] = "You have set this order to preparation mode";
                $data = $row;
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Fail to update this order";
                $data = $row;
            }
        } elseif ($row["order_status"] == "Completed") {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "This job already marked as completed by the rider";
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Order not found";
        $data = $row;
    }

}
if (isset($_POST["viewThisjob_order"])) {
    $id = cleanInput($_POST["viewThisjob_order"]);
    $job_ordersql = "SELECT * FROM job_order WHERE id='$id'";
    $job_orderresult = $db->query($job_ordersql);
    if ($job_orderresult->num_rows > 0) {
        $row = $job_orderresult->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}

if (isset($_POST["viewalljob_order"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE restaurant_id='$uid' AND order_status='New' OR restaurant_id='$uid' AND order_status='Preparing' OR restaurant_id='$uid' AND order_status='Delivering'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["order_date"] = date("F jS, Y, g:i a", strtotime($row["order_date"]));
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No new order";
        $data = $row;
    }
}
if (isset($_POST["runnerprofile"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM users WHERE id='$uid'";
    $result = $db->query($sql);
    $data;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["password"] = "*********";
        $row["status"] = "success";
        $row["message"] = "User Exist";
        $row["login_token"] = "public";
        $productssql = "SELECT * FROM job_order WHERE runner='$uid'";
        $productsresult = $db->query($productssql);
        if ($productsresult->num_rows > 0) {
            while ($prow = $productsresult->fetch_assoc()) {
                $prow["order_date"] = date("F jS, Y", strtotime($prow["order_date"]));
                $prow["name"] = "Medication Delivery";
                $row["job"][] = $prow;
            }
        } else {
            $row["job"] = "empty";
        }
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "This user no longer exist";
        $data = $row;
    }
}
if (isset($_POST["checkcancel"])) {
    $jobid = cleanInput($_POST["checkcancel"]);
    $lat = cleanInput($_POST["lat"]);
    $lng = cleanInput($_POST["lng"]);
    //Update rider location
    $rider = $authUser["id"];
    $sqlcord = "UPDATE users SET lat='$lat', lng='$lng' WHERE id='$rider'";
    $db->query($sqlcord);

    $sql = "SELECT * FROM job_order WHERE id='$jobid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error. Please try again";
        $data = $row;
    }
}

if (isset($_POST["runnersetpickup"])) {
    $job_order = cleanInput($_POST["runnersetpickup"]);
    $rid = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE id='$job_order' AND runner='$rid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $runnerid = $row["runner"];
        $sqlz = "UPDATE job_order SET order_status='Delivering' WHERE id='$job_order'";
        if ($db->query($sqlz) === TRUE) {

        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Fail to update job order";
            $data = $row;
        }
        $row["message"] = "You have set this order as picked up";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Job not found";
        $data = $row;
    }
}
if (isset($_POST["searchRestaurant"])) {
    $restaurantname = cleanInput($_POST["searchRestaurant"]);
    $user_latitude = cleanInput($_POST["lat"]);
    $user_longitude = cleanInput($_POST["lng"]);
    $sql = "SELECT * FROM products WHERE name LIKE '%$restaurantname%'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No Product";
        $data = $row;
    }
}
if (isset($_POST["restaurantcancelorder"])) {
    $job_order = cleanInput($_POST["restaurantcancelorder"]);
    $sql = "SELECT * FROM job_order WHERE id=$job_order";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $runnerid = $row["runner"];
        if ($row["payment_type"] == "Online") {
            $torefund = $row["cart_price"] + $row["delivery_price"];
            $refundowner = $row["owner"];
            $sqlxx = "UPDATE users SET wallet=wallet+'$torefund' WHERE id='$refundowner'";
            if ($db->query($sqlxx) === TRUE) {
            } else {
            }
        }
        if ($row["delyva_order_id"] == "") {
            $sql = "UPDATE users SET availability='Off' WHERE id='$runnerid'";
            if ($db->query($sql) === TRUE) {
                $sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$job_order'";

                if ($db->query($sql) === TRUE) {
                    $row["card"] = "red";
                    $row["status"] = "Successful";
                    $row["message"] = "Your order has been canceled successfully";
                    $data = $row;
                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Runner Not Found";
                    $data = $row;
                }
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Runner Not Found";
                $data = $row;
            }
        } else {

        }

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Job not found";
        $data = $row;
    }
}
if (isset($_POST["runnercancelorder"])) {
    $job_order = cleanInput($_POST["runnercancelorder"]);
    $sql = "SELECT * FROM job_order WHERE id=$job_order";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $runnerid = $row["runner"];
        if ($row["payment_type"] == "Online") {
            $torefund = $row["cart_price"] + $row["delivery_price"];
            $refundowner = $row["owner"];
            $sqlxx = "UPDATE users SET wallet=wallet+'$torefund' WHERE id='$refundowner'";

            if ($db->query($sqlxx) === TRUE) {

            } else {

            }
        }
        $sql = "UPDATE users SET availability='Off' WHERE id='$runnerid'";
        if ($db->query($sql) === TRUE) {
            $sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$job_order'";

            if ($db->query($sql) === TRUE) {
                $row["card"] = "red";
                $row["status"] = "Successful";
                $row["message"] = "Your order has been canceled successfully";
                $data = $row;
            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Runner Not Found";
                $data = $row;
            }
        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Runner Not Found";
            $data = $row;
        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Job not found";
        $data = $row;
    }
}
if (isset($_POST["availability"])) {
    $userid = $authUser["id"];
    $avail = cleanInput($_POST["availability"]);
    /* 	$row["card"] = "red";
	$row["status"] = "Fail";
	$row["message"] = "Account Suspended";
	$data = $row; */
    if ($authUser["type"] == 1 || $authUser["type"] == 4) {
        $sql = "UPDATE users SET availability='$avail' WHERE id='$userid'";

        if ($db->query($sql) === TRUE) {
            $row["card"] = "red";
            $row["status"] = "Successful";
            $row["message"] = "You set your availability to " . $avail;
            $data = $row;
        } else {
            $row["card"] = "red";
            $row["status"] = "Successful";
            $row["message"] = "Your order has been canceled successfully";
            $data = $row;
        }
    } else {

        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Account suspended until futher notice";
        $data = $row;

    }


}
if (isset($_POST["cancelorder"])) {
    $job_order = cleanInput($_POST["cancelorder"]);
    $sql = "SELECT * FROM job_order WHERE id=$job_order";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalpaid = $row["cart_price"] + $row["delivery_price"];
        if ($row["delyva_order_id"] != null) {
            $delyvaorderid = $row["delyva_order_id"];
            include("delyva.php");
            $delyva = new Delyva;
            $accessToken = $delyva->auth();
            $request = $delyva->cancelOrder($delyvaorderid);
            $data["card"] = "red";
            $data["status"] = "Successful";
            $data["did"] = $delyvaorderid;
            $data["message"] = $request;

            $sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$job_order'";
            if ($db->query($sql) === TRUE) {

                $row["card"] = "red";
                $row["status"] = "Successful";
                $row["message"] = "Your order has been canceled successfully";
                $data = $row;

            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Runner Not Found";
                $data = $row;
            }
        }
        if ($row["runner"] != 0) {
            $runnerid = $row["runner"];
            if ($row["payment_type"] == "Online") {

                $torefund = $row["cart_price"] + $row["delivery_price"];
                $refundowner = $row["owner"];
                $sqlxx = "UPDATE users SET wallet=wallet+'$torefund' WHERE id='$refundowner'";

                if ($db->query($sqlxx) === TRUE) {

                } else {

                }
            }
            $sql = "UPDATE users SET availability='Off' WHERE id='$runnerid'";
            if ($db->query($sql) === TRUE) {

                $sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$job_order'";
                if ($db->query($sql) === TRUE) {
                    $row["card"] = "red";
                    $row["status"] = "Successful";
                    $row["message"] = "Your order has been canceled successfully";
                    $data = $row;

                } else {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Runner Not Found";
                    $data = $row;
                }

            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Runner Not Found";
                $data = $row;
            }
        }

        if ($row["speedy_order_id"] != null) {
            $speedydeliveryid = $row["speedy_order_id"];
            cancelOrder($speedydeliveryid);
            $sql = "UPDATE job_order SET order_status='Canceled' WHERE id='$job_order'";
            if ($db->query($sql) === TRUE) {
                $row["card"] = "red";
                $row["status"] = "Successful";
                $row["message"] = "Your order has been canceled successfully";
                $data = $row;

            } else {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Runner Not Found";
                $data = $row;
            }

        }
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Job not found";
        $data = $row;
    }
}
if (isset($_POST["currentjob"])) {

}
if (isset($_POST["orderstatus"])) {
    $orderid = cleanInput($_POST["orderstatus"]);
    $sql = "SELECT * FROM job_order WHERE id='$orderid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $orderdata = $result->fetch_assoc();
        $data = $orderdata;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "This order does not exist";
        $data = $row;
    }
}
if (isset($_POST["vieworder"])) {
    $orderid = cleanInput($_POST["vieworder"]);
    $sql = "SELECT * FROM job_order WHERE id='$orderid'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $orderdata = $result->fetch_assoc();

        $runnerid = $orderdata["runner"];
        $sqlz = "SELECT * FROM users WHERE id='$runnerid'";
        $resultz = $db->query($sqlz);

        if ($resultz->num_rows > 0) {
            $rowz = $resultz->fetch_assoc();
            $orderdata["lat"] = $rowz["lat"];
            $orderdata["lng"] = $rowz["lng"];
        }
        $data = $orderdata;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "This order does not exist";
        $data = $row;
    }
}
if (isset($_POST["processorderonline"])) {
    $owner = $authUser["id"];
    $cartdata = cleanInput($_POST["processorderonline"]);
    $restaurantprofit = cleanInput($_POST["restaurantprofit"]);
    $order_date = $currentdatetime;
    $order_status = "New";
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    $restaurantid = cleanInput($_POST["restaurantid"]);
    $paymentmethod = cleanInput($_POST["paymentmethod"]);
    $cart_price = cleanInput($_POST["cart_price"]);
    $delivery_price = cleanInput($_POST["deliveryPrice"]);
    $delivery_lat = cleanInput($_POST["delivery_lat"]);
    $delivery_lng = cleanInput($_POST["delivery_lng"]);
    $promo = cleanInput($_POST["promo"]);
    if ($cartdata == "Array") {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Please try again";
        $data = $row;

    } else {
        $selectedRunnerid = 0;
        $job_ordersql = "INSERT INTO temp_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, pickup_lat, pickup_lng)
		VALUES ('$owner', '$cartdata', '$order_date', '$order_status', '$selectedRunnerid', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$delivery_price', '$promo', '$first_restaurant_lat', '$first_restaurant_lng')";

        if ($db->query($job_ordersql) === TRUE) {
            $templast_id = $db->insert_id;
            $sql = "DELETE FROM carts WHERE owner='$owner'";
            $db->query($sql);
            $row["card"] = "green";
            $row["order_id"] = $last_id;
            $userid = $authUser["id"];
            if ($promo > 0) {
                $promotedamount = $promo * $delivery_price / 100;
                $delivery_price = $delivery_price - $promotedamount;
            }
            $amount = $cart_price + $delivery_price;
            $fullname = $authUser["firstname"] . ' ' . $authUser["lastname"];
            $email = $authUser["email"];
            $phone_number = $authUser["phonenumber"];
            $type = $templast_id;

            $sql = "INSERT INTO senangpay (user_id, amount, order_status, phone_number, email, fullname, type)
					VALUES ('$userid', '$amount', 'waiting', '$phone_number', '$email', '$fullname', '$type')";
            if ($db->query($sql) === TRUE) {
                $last_id = $db->insert_id;
                $row["status"] = "success";
                $row["message"] = "Session requested successfully";
                $row["orderid"] = $last_id;
            } else {
                $row["status"] = "fail";
                $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            }

            $data = $row;


        } else {
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    }
}

if (isset($_POST["processorder"])) {
    /* 	include("delyva.php");
	$delyvacreatedata = cleanInput($_POST["delyvacreatedata"]);
	$serviceCode = cleanInput($_POST["purchaseoff"]);
	$delyvacreatedata = base64_decode($delyvacreatedata);
	$delyvacreatedata = json_decode($delyvacreatedata);
	$delyva = new Delyva;
	$accessToken = $delyva->auth();
	$request = $delyva->createOrder($delyvacreatedata);
	$delyvaorderid = $request->data->orderId;
	$process = $delyva->processOrder($delyvaorderid, $serviceCode);
	$data = $process; */
    $owner = $authUser["id"];
    $datax = cleanInput($_POST["processorder"]);
    $speedydata = $_POST["processorder"];
    $order_date = $currentdatetime;
    $order_status = "New";
    $deliverytype = cleanInput($_POST["deliverytype"]);
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    $restaurantid = cleanInput($_POST["restaurantid"]);
    $paymentmethod = cleanInput($_POST["paymentmethod"]);
    $docearning = cleanInput($_POST["docearning"]);
    $cart_price = cleanInput($_POST["cart_price"]);
    $delivery_price = cleanInput($_POST["deliveryPrice"]);
    $delivery_lat = cleanInput($_POST["delivery_lat"]);
    $delivery_lng = cleanInput($_POST["delivery_lng"]);
    $restaurantprofit = cleanInput($_POST["restaurantprofit"]);
    $purchaseoff = cleanInput($_POST["purchaseoff"]);

    if ($deliverytype == "pickup") {
        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id, deliverytype)VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '0.00', '0.00', '$speedyorderid', 'pickup')";
        if ($db->query($job_ordersql) === TRUE) {
            $last_id = $db->insert_id;
            $sql = "DELETE FROM carts WHERE owner='$owner'";
            $db->query($sql);
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "Self Pick Up Order";
            $row["order_id"] = $last_id;
            $data = $row;
        } else {
            $row["payment_amount"] = $payment_amount;
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
            $data = $row;
        }
    }
    if ($deliverytype == "delivery") {


        $serviceCode = cleanInput($_POST["purchaseoff"]);
        if ($serviceCode == "EPINK") {
            $deliveryPrice = cleanInput($_POST["deliveryPrice"]);

            $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id, deliverytype)VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$deliveryPrice', '0.00', '$speedyorderid', 'Delivery')";
            if ($db->query($job_ordersql) === TRUE) {
                $last_id = $db->insert_id;
                $sql = "DELETE FROM carts WHERE owner='$owner'";
                $db->query($sql);
                $row["card"] = "green";
                $row["status"] = "Successful";
                $row["message"] = "Self Pick Up Order";
                $row["order_id"] = $last_id;
                $data = $row;
            } else {
                $row["payment_amount"] = $payment_amount;
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                $data = $row;
            }
        } else {
            include("delyva.php");
            $delyvacreatedata = cleanInput($_POST["delyvacreatedata"]);
            $deliveryPrice = cleanInput($_POST["deliveryPrice"]);
            $delyvacreatedata = base64_decode($delyvacreatedata);
            $delyvacreatedata = json_decode($delyvacreatedata);
            $delyva = new Delyva;
            $accessToken = $delyva->auth();
            $request = $delyva->createOrder($delyvacreatedata);

            //echo json_encode($request, JSON_PRETTY_PRINT);
            $delyva_order_id = $request->data->id;
            $delyvastatuscode = $request->data->statusCode;
            //$data["aresponse"] = $request;
            //$data["delyvastatuscode"] = $delyvastatuscode;
            $data["delyva_order_id"] = $delyva_order_id;

            if ($delyva_order_id != "") {
                $data["delyvaresponse"] = $request;
                $job_ordersql = "INSERT INTO job_order (
				owner, 
				data, 
				order_date, 
				order_status, 
				runner, 
				restaurant_id, 
				payment_type, 
				cart_price, 
				restaurant_profit, 
				delivery_lat, 
				delivery_lng, 
				delivery_price, 
				promo, 
				delyva_order_id,
				delyva_order_status,
				delyva_service_code
				)
				VALUES (
				'$owner', 
				'$datax', 
				'$order_date', 
				'$order_status', 
				'0', 
				'$restaurantid', 
				'$paymentmethod', 
				'$cart_price', 
				'$restaurantprofit', 
				'$delivery_lat', 
				'$delivery_lng', 
				'$deliveryPrice', 
				'0.00', 
				'$delyva_order_id',
				'$delyvastatuscode',
				'$serviceCode'
				)";

                if ($db->query($job_ordersql) === TRUE) {
                    $last_id = $db->insert_id;
                    $sql = "DELETE FROM carts WHERE owner='$owner'";
                    $db->query($sql);
                    $row["card"] = "green";
                    $row["status"] = "Successful";
                    $row["message"] = "Runner is on the way to pick up your order";
                    $row["order_id"] = $last_id;
                    $data = $row;
                } else {
                    $row["payment_amount"] = $payment_amount;
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                    $data = $row;
                }
            } else {
                $data["delyvaresponse"] = $request;
            }
        }


    }
    if ($deliverytype == "deliverys") {
        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id, deliverytype)VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '0.00', '0.00', '$speedyorderid', 'pickup')";
        if ($db->query($job_ordersql) === TRUE) {
            $last_id = $db->insert_id;
            $sql = "DELETE FROM carts WHERE owner='$owner'";
            $db->query($sql);
            $row["card"] = "green";
            $row["status"] = "Successful";
            $row["message"] = "Self Pick Up Order";
            $row["order_id"] = $last_id;
            $data = $row;
        } else {
            $row["payment_amount"] = $payment_amount;
            $row["card"] = "red";
            $row["status"] = "Fail";
            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
            $data = $row;
        }

    }

}
if (isset($_POST["processorders"])) {
    $owner = $authUser["id"];
    $datax = cleanInput($_POST["processorder"]);
    $speedydata = $_POST["processorder"];
    $order_date = $currentdatetime;
    $order_status = "New";
    $deliverytype = cleanInput($_POST["deliverytype"]);
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    $restaurantid = cleanInput($_POST["restaurantid"]);
    $paymentmethod = cleanInput($_POST["paymentmethod"]);
    $docearning = cleanInput($_POST["docearning"]);
    $cart_price = cleanInput($_POST["cart_price"]);
    $delivery_price = cleanInput($_POST["deliveryPrice"]);
    $delivery_lat = cleanInput($_POST["delivery_lat"]);
    $delivery_lng = cleanInput($_POST["delivery_lng"]);
    $restaurantprofit = cleanInput($_POST["restaurantprofit"]);
    $purchaseoff = cleanInput($_POST["purchaseoff"]);
    $restaurantprofit = floatval($restaurantprofit);
    $promo = cleanInput($_POST["promo"]);
    if ($_POST["requireteleconsultation"] == "true") {
        if ($restaurantprofit != 0.00) {
            $sqlspeed = "SELECT phonenumber, vendor_address, vendor_name, email FROM users WHERE id='$restaurantid'";
            $resultspeed = $db->query($sqlspeed);
            if ($resultspeed->num_rows > 0) {
                $rowspeed = $resultspeed->fetch_assoc();
                $speedy_vendor_address = $rowspeed["vendor_address"];
                $speedy_vendor_name = $rowspeed["vendor_name"];
                $speedy_vendor_phonenumber = $rowspeed["phonenumber"];
                $vendoremail = $rowspeed["email"];
            }
            $sqlspeedowner = "SELECT firstname, lastname, phonenumber FROM users WHERE id='$owner'";
            $resultspeedowner = $db->query($sqlspeedowner);
            if ($resultspeedowner->num_rows > 0) {
                $rowspeedowner = $resultspeedowner->fetch_assoc();
                $speedy_first_name = $rowspeedowner["firstname"];
                $speedy_last_name = $rowspeedowner["lastname"];
                $speedy_customer_phonenumber = $rowspeedowner["phonenumber"];
            }
            if ($paymentmethod == "COD") {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "This payment method has been disabled. Please try different payment method.";
                $data = $row;
            } else {
                if ($datax == "Array") {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Please try again";
                    $data = $row;
                } else {
                    $sqlfloat = "SELECT * FROM job_order WHERE owner='$owner' AND order_status='New' OR owner='$owner' AND order_status='Preparing' OR owner='$owner' AND order_status='Delivering'";
                    $floatresult = $db->query($sqlfloat);
                    $floatingamount = 0.00;
                    if ($floatresult->num_rows > 0) {

                        while ($floatrow = $floatresult->fetch_assoc()) {
                            $thisjobtotal = $floatrow["delivery_price"] + $floatrow["cart_price"];
                            $floatingamount = $floatingamount + $thisjobtotal;
                        }

                    } else {
                        $floatingamount = 0.00;
                    }
                    $orderfloat = $floatingamount + $cart_price + $delivery_price;

                    if ($orderfloat > $authUser["wallet"]) {
                        $row["card"] = "green";
                        $row["status"] = "Fail";
                        $row["message"] = "Insufficient Wallet Balance.";
                        $data = $row;
                    } else {

                        $decodedr = json_decode($speedydata);
                        $row["vendor_name"] = $speedy_vendor_name;
                        $row["vendor_phonenumber"] = $speedy_vendor_phonenumber;
                        $row["vendor_address"] = $speedy_vendor_address;
                        if (strpos($row["vendor_address"], "Sabah") !== false) {
                            $row["card"] = "green";
                            $row["status"] = "Fail";
                            $row["message"] = "Sorry this area is still not covered";

                            $data = $row;
                        } else {


                            $row["customer_name"] = $speedy_first_name . ' ' . $speedy_last_name;
                            $row["customer_phonenumber"] = $speedy_customer_phonenumber;
                            $row["delivery_address"] = $decodedr->delivery_address;
                            $speedycheck = getPrice($row["vendor_address"], $row["delivery_address"]);
                            $speedycheck = false;
                            if ($_POST["deliverytype"] == "delivery") {
                                if ($speedycheck == true) {
                                    $make = json_decode(requestSpeedy($row["customer_name"], $row["customer_phonenumber"], $row["delivery_address"], $row["vendor_name"], $row["vendor_phonenumber"], $row["vendor_address"], '1'));
                                    $sresult = $make;
                                    if ($make->is_successful == true) {

                                        $speedyorderid = $make->order->order_id;
                                        $payment_amount = $make->order->payment_amount;
                                        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', '$order_status', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                        if ($db->query($job_ordersql) === TRUE) {
                                            $last_id = $db->insert_id;
                                            $sql = "DELETE FROM carts WHERE owner='$owner'";
                                            $db->query($sql);

                                            $row["card"] = "green";
                                            $row["status"] = "Successful";
                                            $row["message"] = "Runner is on the way to pick up your order";
                                            $row["order_id"] = $last_id;
                                            $data = $row;
                                        } else {
                                            $row["payment_amount"] = $payment_amount;
                                            $row["card"] = "red";
                                            $row["status"] = "Fail";
                                            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                            $data = $row;
                                        }

                                    } else {
                                        $speedyorderid = 0;
                                        $payment_amount = $delivery_price;
                                        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                        if ($db->query($job_ordersql) === TRUE) {
                                            $last_id = $db->insert_id;
                                            $sql = "DELETE FROM carts WHERE owner='$owner'";
                                            $db->query($sql);

                                            $row["card"] = "green";
                                            $row["status"] = "Successful";
                                            $row["message"] = "Runner is on the way to pick up your order";
                                            $row["order_id"] = $last_id;
                                            $data = $row;
                                        } else {
                                            $row["payment_amount"] = $payment_amount;
                                            $row["card"] = "red";
                                            $row["status"] = "Fail";
                                            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                            $data = $row;
                                        }
                                    }
                                } else {

                                    $speedyorderid = 0;
                                    $payment_amount = $delivery_price;
                                    $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                    if ($db->query($job_ordersql) === TRUE) {
                                        $last_id = $db->insert_id;
                                        $sql = "DELETE FROM carts WHERE owner='$owner'";
                                        $db->query($sql);

                                        $row["card"] = "green";
                                        $row["status"] = "Successful";
                                        $row["message"] = "Runner is on the way to pick up your order";
                                        $row["order_id"] = $last_id;
                                        $data = $row;
                                        $amountotcut = $cart_price;
                                        $owner_two = cleanInput($_POST["docid"]);
                                        $owner_one = $authUser["id"];
                                        $active = "true";
                                        $type = "both";
                                        $session_status = "new";


                                        $session_reason = "This user require a tele consultation for the purchase of " . $purchaseoff;
                                        $session_date = $currentdatetime;
                                        $diagnose = "";
                                        $prescription = cleanInput($_POST["prescription"]);
                                        $paid = "";
                                        $sppaid = "true";
                                        $archive = "";
                                        $mcdata = null;
                                        $referto = null;
                                        $clincalNote = null;
                                        $savedclinicalnote = null;
                                        $signedclinicalnote = null;
                                        $signedpres = null;
                                        $signedmc = null;
                                        $delivery_address = cleanInput($_POST["delivery_address"]);
                                        $delivery_completed = cleanInput($_POST["delivery_completed"]);
                                        $delivery_fee = cleanInput($_POST["delivery_fee"]);
                                        $storeid = cleanInput($_POST["restaurantid"]);
                                        $storeapprove = cleanInput($_POST["storeapprove"]);
                                        $runnedid = cleanInput($_POST["runnedid"]);
                                        $saved_pres = cleanInput($_POST["saved_pres"]);
                                        $saved_mc = cleanInput($_POST["saved_mc"]);
                                        $doctor = "true";
                                        $savedrefer = null;
                                        $signedrefer = null;
                                        $doctorearning = cleanInput($_POST["docearning"]);

                                        $fromcart = "true";
                                        $chatssql = "INSERT INTO chats (owner_one, owner_two, active, type, session_status, session_reason, session_date, diagnose, prescription, paid, sppaid, archive, referto, clincalNote, savedclinicalnote, signedclinicalnote, signedpres, signedmc, delivery_address, delivery_completed, delivery_fee, storeid, storeapprove, runnedid, saved_pres, saved_mc, doctor, savedrefer, signedrefer, doctorearning, fromcart, joborderid)
		VALUES ('$owner_one', '$owner_two', '$active', '$type', '$session_status', '$session_reason', '$session_date', '$diagnose', '$prescription', '$paid', '$sppaid', '$archive', '$referto', '$clincalNote', '$savedclinicalnote', '$signedclinicalnote', '$signedpres', '$signedmc', '$delivery_address', '$delivery_completed', '$delivery_fee', '$storeid', '$storeapprove', '$runnedid', '$saved_pres', '$saved_mc', '$doctor', '$savedrefer', '$signedrefer', '$doctorearning', '$fromcart', '$last_id')";

                                        if ($db->query($chatssql) === TRUE) {
                                            $last_id = $db->insert_id;
                                            $row["card"] = "green";
                                            $row["status"] = "Successful";
                                            $row["message"] = "New record successfully created";
                                            $data = $row;
                                        } else {
                                            $row["card"] = "red";
                                            $row["status"] = "Fail";
                                            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                                            $data = $row;
                                        }
                                    } else {
                                        $row["payment_amount"] = $payment_amount;
                                        $row["card"] = "red";
                                        $row["status"] = "Fail";
                                        $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                        $data = $row;
                                    }
                                }

                            } else {
                                $speedyorderid = 0;
                                $payment_amount = $delivery_price;
                                $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id, deliverytype)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '0.00', '0.00', '$speedyorderid', 'pickup')";

                                if ($db->query($job_ordersql) === TRUE) {
                                    $last_id = $db->insert_id;
                                    $sql = "DELETE FROM carts WHERE owner='$owner'";
                                    $db->query($sql);

                                    $row["card"] = "green";
                                    $row["status"] = "Successful";
                                    $row["message"] = "Runner is on the way to pick up your order";
                                    $row["order_id"] = $last_id;
                                    $data = $row;
                                } else {
                                    $row["payment_amount"] = $payment_amount;
                                    $row["card"] = "red";
                                    $row["status"] = "Fail";
                                    $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                    $data = $row;
                                }
                            }
                        }

                        //Enter Done

                    }
                }
            }
        } else {
            $row["status"] = "Fail";
            $row["message"] = "Please reset the app and try again.";
            $data = $row;
        }

    }


    $delyvacreatedata = cleanInput($_POST["delyvacreatedata"]);
    $delyvacreatedata = base64_decode($delyvacreatedata);

    if ($_POST["requireteleconsultation"] == "false") {
        if ($restaurantprofit != 0.00) {
            $sqlspeed = "SELECT phonenumber, vendor_address, vendor_name, email FROM users WHERE id='$restaurantid'";
            $resultspeed = $db->query($sqlspeed);
            if ($resultspeed->num_rows > 0) {
                $rowspeed = $resultspeed->fetch_assoc();
                $speedy_vendor_address = $rowspeed["vendor_address"];
                $speedy_vendor_name = $rowspeed["vendor_name"];
                $speedy_vendor_phonenumber = $rowspeed["phonenumber"];
                $vendoremail = $rowspeed["email"];
            }
            $sqlspeedowner = "SELECT firstname, lastname, phonenumber FROM users WHERE id='$owner'";
            $resultspeedowner = $db->query($sqlspeedowner);
            if ($resultspeedowner->num_rows > 0) {
                $rowspeedowner = $resultspeedowner->fetch_assoc();
                $speedy_first_name = $rowspeedowner["firstname"];
                $speedy_last_name = $rowspeedowner["lastname"];
                $speedy_customer_phonenumber = $rowspeedowner["phonenumber"];
            }
            if ($paymentmethod == "COD") {
                $row["card"] = "red";
                $row["status"] = "Fail";
                $row["message"] = "This payment method has been disabled. Please try different payment method.";
                $data = $row;
            } else {
                if ($datax == "Array") {
                    $row["card"] = "red";
                    $row["status"] = "Fail";
                    $row["message"] = "Please try again";
                    $data = $row;
                } else {
                    $sqlfloat = "SELECT * FROM job_order WHERE owner='$owner' AND order_status='New' OR owner='$owner' AND order_status='Preparing' OR owner='$owner' AND order_status='Delivering'";
                    $floatresult = $db->query($sqlfloat);
                    $floatingamount = 0.00;
                    if ($floatresult->num_rows > 0) {

                        while ($floatrow = $floatresult->fetch_assoc()) {
                            $thisjobtotal = $floatrow["delivery_price"] + $floatrow["cart_price"];
                            $floatingamount = $floatingamount + $thisjobtotal;
                        }

                    } else {
                        $floatingamount = 0.00;
                    }
                    $orderfloat = $floatingamount + $cart_price + $delivery_price;

                    if ($orderfloat > $authUser["wallet"]) {
                        $row["card"] = "green";
                        $row["status"] = "Fail";
                        $row["message"] = "Insufficient Wallet Balance.";
                        $data = $row;

                    } else {

                        $decodedr = json_decode($speedydata);
                        $row["vendor_name"] = $speedy_vendor_name;
                        $row["vendor_phonenumber"] = $speedy_vendor_phonenumber;
                        $row["vendor_address"] = $speedy_vendor_address;
                        if (strpos($row["vendor_address"], "Sabah") !== false) {
                            $row["card"] = "green";
                            $row["status"] = "Fail";
                            $row["message"] = "Sorry this area is still not covered";

                            $data = $row;
                        } else {


                            $row["customer_name"] = $speedy_first_name . ' ' . $speedy_last_name;
                            $row["customer_phonenumber"] = $speedy_customer_phonenumber;
                            $row["delivery_address"] = $decodedr->delivery_address;
                            $speedycheck = getPrice($row["vendor_address"], $row["delivery_address"]);
                            $speedycheck = false;

                            if ($_POST["deliverytype"] == "delivery") {

                                if ($speedycheck == true) {
                                    $make = json_decode(requestSpeedy($row["customer_name"], $row["customer_phonenumber"], $row["delivery_address"], $row["vendor_name"], $row["vendor_phonenumber"], $row["vendor_address"], '1'));
                                    $sresult = $make;
                                    if ($make->is_successful == true) {

                                        $speedyorderid = $make->order->order_id;
                                        $payment_amount = $make->order->payment_amount;
                                        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', '$order_status', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                        if ($db->query($job_ordersql) === TRUE) {
                                            $last_id = $db->insert_id;
                                            $sql = "DELETE FROM carts WHERE owner='$owner'";
                                            $db->query($sql);

                                            $row["card"] = "green";
                                            $row["status"] = "Successful";
                                            $row["message"] = "Runner is on the way to pick up your order";
                                            $row["order_id"] = $last_id;
                                            $data = $row;
                                        } else {
                                            $row["payment_amount"] = $payment_amount;
                                            $row["card"] = "red";
                                            $row["status"] = "Fail";
                                            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                            $data = $row;
                                        }

                                    } else {
                                        $speedyorderid = 0;
                                        $payment_amount = $delivery_price;
                                        $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                        if ($db->query($job_ordersql) === TRUE) {
                                            $last_id = $db->insert_id;
                                            $sql = "DELETE FROM carts WHERE owner='$owner'";
                                            $db->query($sql);

                                            $row["card"] = "green";
                                            $row["status"] = "Successful";
                                            $row["message"] = "Runner is on the way to pick up your order";
                                            $row["order_id"] = $last_id;
                                            $data = $row;
                                        } else {
                                            $row["payment_amount"] = $payment_amount;
                                            $row["card"] = "red";
                                            $row["status"] = "Fail";
                                            $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                            $data = $row;
                                        }
                                    }
                                } else {

                                    $speedyorderid = 0;
                                    $payment_amount = $delivery_price;
                                    $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '$payment_amount', '0.00', '$speedyorderid')";

                                    if ($db->query($job_ordersql) === TRUE) {
                                        $last_id = $db->insert_id;
                                        $sql = "DELETE FROM carts WHERE owner='$owner'";
                                        $db->query($sql);

                                        $row["card"] = "green";
                                        $row["status"] = "Successful";
                                        $row["message"] = "Runner is on the way to pick up your order";
                                        $row["order_id"] = $last_id;
                                        $data = $row;
                                    } else {
                                        $row["payment_amount"] = $payment_amount;
                                        $row["card"] = "red";
                                        $row["status"] = "Fail";
                                        $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                        $data = $row;
                                    }
                                }

                            } else {
                                $speedyorderid = 0;
                                $payment_amount = $delivery_price;
                                $job_ordersql = "INSERT INTO job_order (owner, data, order_date, order_status, runner, restaurant_id, payment_type, cart_price, restaurant_profit, delivery_lat, delivery_lng, delivery_price, promo, speedy_order_id, deliverytype)
											VALUES ('$owner', '$datax', '$order_date', 'New', '0', '$restaurantid', '$paymentmethod', '$cart_price', '$restaurantprofit', '$delivery_lat', '$delivery_lng', '0.00', '0.00', '$speedyorderid', 'pickup')";

                                if ($db->query($job_ordersql) === TRUE) {
                                    $last_id = $db->insert_id;
                                    $sql = "DELETE FROM carts WHERE owner='$owner'";
                                    $db->query($sql);

                                    $row["card"] = "green";
                                    $row["status"] = "Successful";
                                    $row["message"] = "Runner is on the way to pick up your order";
                                    $row["order_id"] = $last_id;
                                    $data = $row;
                                } else {
                                    $row["payment_amount"] = $payment_amount;
                                    $row["card"] = "red";
                                    $row["status"] = "Fail";
                                    $row["message"] = "Error: " . $job_ordersql . "<br>" . $db->error;
                                    $data = $row;
                                }
                            }
                        }

                        //Enter Done

                    }
                }
            }
        } else {
            $row["status"] = "Fail";
            $row["message"] = "Please reset the app and try again.";
            $data = $row;
        }


    }

}
if (isset($_POST["deleteproduct"])) {
    $productid = cleanInput($_POST["deleteproduct"]);
    $sql = "DELETE FROM products WHERE id='$productid'";

    if ($db->query($sql) === TRUE) {
        $row["status"] = "Successfull";
        $row["message"] = "The menu has been deleted";
        $data = $row;
    } else {
        $row["status"] = "Fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["viewvendorproduct"])) {
    $vendor_id = cleanInput($_POST["viewvendorproduct"]);
    $sql = "SELECT * FROM products WHERE owner='$vendor_id' and available='On'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    $unit = "K";
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

if (isset($_POST["inserttocarts"])) {
    $owner = $authUser["id"];
    $product_id = cleanInput($_POST["product_id"]);
    $product_owner = cleanInput($_POST["restaurant_id"]);
    $quantity = cleanInput($_POST["quantity"]);
    $ordermessage = cleanInput($_POST["message"]);
    $addon = cleanInput($_POST["addon"]);
    $prescription = cleanInput($_POST["requireprescription"]);
    if ($owner != "" && $product_id != "" && $quantity != "") {
        $sqlox = "DELETE FROM carts WHERE owner='$owner' AND product_owner != '$product_owner'";

        if ($db->query($sqlox) === TRUE) {

            $cartssql = "SELECT * FROM carts WHERE product_id='$product_id' AND owner='$owner'";
            $cartsresult = $db->query($cartssql);
            if ($cartsresult->num_rows > 0) {
                $row["status"] = "fail";
                $row["message"] = "You already have this item in your cart";
                $data = $row;

            } else {

                $sqlzo = "SELECT * FROM products WHERE id='$product_id'";
                $resultzo = $db->query($sqlzo);

                if ($resultzo->num_rows > 0) {
                    $rowzo = $resultzo->fetch_assoc();
                    $productoriginalprice = $rowzo["originalprice"];
                }
                $cartssql = "INSERT INTO carts (owner, product_id, product_owner, quantity, originalprice, message, addon, prescription)
				VALUES ('$owner', '$product_id', '$product_owner', '$quantity', '$productoriginalprice', '$ordermessage', '$addon', '$prescription')";

                if ($db->query($cartssql) === TRUE) {
                    $row["status"] = "successful";
                    $row["message"] = "New record successfully created";
                    $data = $row;
                } else {
                    $row["status"] = "fail";
                    $row["message"] = "Error: " . $sql . "<br>" . $db->error;
                    $data = $row;
                }
            }

        } else {
            $row["status"] = "fail";
            $row["message"] = "Error: " . $sqlox . "<br>" . $db->error;
            $data = $row;
        }


    } else {
        $row["status"] = "fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
if (isset($_POST["deleteFromcarts"])) {
    $owner = $authUser["id"];
    $id = cleanInput($_POST["deleteFromcarts"]);
    $sql = "DELETE FROM carts WHERE id='$id' AND owner='$owner'";
    if ($db->query($sql) === TRUE) {
        $row["status"] = "success";
        $row["message"] = 'The item has been deleted successfully';
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "Error deleting record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["viewmycart"])) {
    $cart["contact_name"] = $authUser["firstname"] . ' ' . $authUser["lastname"];
    $cart["profile_img"] = $authUser["profile_img"];
    $cart["owner"] = $authUser["id"];
    $cart["phonenumber"] = $authUser["phonenumber"];
    $uid = $authUser["id"];
    $sql = "SELECT * FROM carts WHERE owner='$uid'";
    $result = $db->query($sql);
    $gotpres = 0;
    if ($result->num_rows > 0) {
        // output data of each row
        $curItemlat = '';
        $curItemlng = '';
        $curloop = 0;
        $totaldistance = 0.00;
        $action = 'Action List ->';

        while ($row = $result->fetch_assoc()) {
            $productid = $row["product_id"];
            $sqls = "SELECT * FROM products WHERE id='$productid'";
            $results = $db->query($sqls);
            if ($results->num_rows > 0) {
                $rows = $results->fetch_assoc();
                $row["exist"] = true;
                $row["product_name"] = $rows["name"];
                $row["product_stock"] = $rows["stock"];
                $row["product_picture"] = $rows["picture"];
                $row["product_price"] = $rows["price"];
                if ($row["prescription"] == true || $row["prescription"] == "true") {
                    $productname .= ' ' . $row["product_name"] . ' ';
                    $gotpres++;


                }

                $productownerid = $rows["owner"];
                $sqlvendor = "SELECT * FROM users WHERE id='$productownerid'";
                $resultvendor = $db->query($sqlvendor);
                if ($resultvendor->num_rows > 0) {
                    $rowvendor = $resultvendor->fetch_assoc();
                    $row["vendor_name"] = $rowvendor["vendor_name"];
                    $row["vendor_address"] = $rowvendor["vendor_address"];
                    $row["vendor_street_address"] = $rowvendor["vendor_street_address"];
                    $row["vendor_city"] = $rowvendor["vendor_city"];
                    $row["vendor_postcode"] = $rowvendor["vendor_postcode"];
                    $row["vendor_state"] = $rowvendor["vendor_state"];
                    $row["vendor_country"] = $rowvendor["vendor_country"];
                    $row["vendor_lat"] = $rowvendor["lat"];
                    $row["vendor_lng"] = $rowvendor["lng"];
                    $assigneddoctor = $rowvendor["assigneddoctor"];
                }
                if ($curloop == 0) {
                    $curItemlat = $row["vendor_lat"];
                    $curItemlng = $row["vendor_lng"];
                    $curloop++;
                    $action .= 'Got the first coordinates which is (' . $curItemlat . ', ' . $curItemlng . ')';
                } else {
                    $action .= 'Got the ' . $curloop . ' coordinates which is (' . $rows["lat"] . ' , ' . $rows["lng"] . ')';
                    $getcurdistance = getDistance($curItemlat, $curItemlng, $rows["lat"], $rows["lng"], "K");
                    $totaldistance = $totaldistance + $getcurdistance;
                    $curItemlat = $rows["lat"];
                    $curItemlng = $rows["lng"];
                    $curloop++;
                }

                $row["lat"] = $rows["lat"];
                $row["lon"] = $rows["lng"];

                $dimension = [
                    "width" => $rows["width"],
                    "height" => $rows["height"],
                    "length" => $rows["length"],
                    "unit" => "cm",
                ];
                $weight = ["unit" => $rows["weightunit"], "value" => $rows["weight"]];

                $row["dimension"] = $dimension;
                $row["weight"] = $weight;


            } else {
                $row["exist"] = false;
                $row["product_name"] = 'No longer available';
                $row["product_stock"] = '0';
            }

            $product[] = $row;
        }
        $presowner = $authUser["id"];
        $sqlpres = "SELECT * FROM prescriptions WHERE prescribe_to='$presowner'";
        $resultpress = $db->query($sqlpres);
        if ($resultpress->num_rows > 0) {
            // output data of each row
            while ($rowpress = $resultpress->fetch_assoc()) {
                $prescriptionlist[] = $rowpress;
            }
        } else {
            $prescriptionlist = null;
        }
        if ($gotpres > 0) {
            $sqlsuggestdoc = "SELECT id, fullname, profile_img, provider_type FROM users WHERE id='$assigneddoctor'";
            $resultsuggestdoc = $db->query($sqlsuggestdoc);

            if ($resultsuggestdoc->num_rows > 0) {
                while ($docsuggest = $resultsuggestdoc->fetch_assoc()) {

                    $docsuggest["doctor_rate"] = getInhouseRate();
                    $suggesteddoctor[] = $docsuggest;
                }
            } else {
                $suggesteddoctor = null;
            }

            $sidenote = 'Tele consultation for the purchase of ';
            $sidenote .= $productname;
            $sidenote .= 'from ' . $rowvendor["vendor_name"];
        }
        $data["vendorInformation"] = getVendorprofile($productownerid);
        $data["delyvapickup"] = constructDelyvaAddress($productownerid);
        $data["customer_detail"] = $cart;
        $data["sidenote"] = $sidenote;
        $data["gotpres"] = $gotpres;
        $data["suggesteddoctor"] = $suggesteddoctor;
        $data["price_per_km"] = $priceperkm;
        $data["cartitem"] = $product;
        $data["item_distances"] = $totaldistance;
        $data["prescriptionlist"] = $prescriptionlist;
        //$data["actions"] = $action;


    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}
if (isset($_POST["myproduct"])) {
    $uid = $authUser["id"];
    $categories = json_decode($authUser["pharma_categories"]);
    $categorycount = count($categories);
    for ($x = 0; $x < $categorycount; $x++) {
        $getallitemfromcategory = $categories[$x]->name;
        $sql = "SELECT * FROM products WHERE category ='$getallitemfromcategory' AND owner='$uid'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($productrow = $result->fetch_assoc()) {
                $item[] = $productrow;
            }
        } else {
            $item = null;
        }
        $categories[$x]->items = $item;

    }
    $data = $categories;
}

if (isset($_POST["viewallorders"])) {
    $owner = $authUser["id"];
    $sql = "SELECT * FROM job_order WHERE owner='$owner'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["order_date"] = date("F jS, Y", strtotime($row["order_date"]));
            $pid = $row["product_id"];
            $productssql = "SELECT * FROM products WHERE id='$pid'";
            $productsresult = $db->query($productssql);
            if ($productsresult->num_rows > 0) {
                $productsdata = $productsresult->fetch_assoc();
            }
            $row["product_name"] = $productsdata["name"];
            $row["product_picture"] = $productsdata["picture"];
            $data[] = $row;

        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["mysales"])) {
    $sellerid = $authUser["id"];
    $sql = "SELECT * FROM orders WHERE product_owner='$sellerid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["order_date"] = date("F jS, Y", strtotime($row["order_date"]));
            $pid = $row["product_id"];
            $productssql = "SELECT * FROM products WHERE id='$pid'";
            $productsresult = $db->query($productssql);
            if ($productsresult->num_rows > 0) {
                $productsdata = $productsresult->fetch_assoc();
            }
            $row["product_name"] = $productsdata["name"];
            $row["product_picture"] = $productsdata["picture"];
            $data[] = $row;

        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Database is empty";
        $data = $row;
    }
}

if (isset($_POST["pharmainformation"])) {
    $id = cleanInput($_POST["pharmainformation"]);
    $sqlrun = "SELECT * FROM users WHERE id='$id'";
    $runresult = $db->query($sqlrun);
    if ($runresult->num_rows > 0) {
        $rows = $runresult->fetch_assoc();
        $data["vendor_name"] = $rows["vendor_name"];
        $data["vendor_category"] = $rows["pharma_categories"];
    }
}
if (isset($_POST["loadmorehomepagecontent"])) {
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $lastidloadmore = cleanInput($_POST["last"]);
    $sub = cleanInput($_POST["sub"]);
    $gethomepage = cleanInput($_POST["gethomepage"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    $pharmaid = cleanInput($_POST["pharmaid"]);
    if ($pharmaid == 0) {
        $sqlrun = "SELECT * FROM users WHERE provider_type='Pharmacist' AND verified_service_provider='Approved'";
    } else {
        $sqlrun = "SELECT * FROM users WHERE id='$pharmaid'";
    }
    $runresult = $db->query($sqlrun);
    if ($runresult->num_rows > 0) {
        $rows = $runresult->fetch_assoc();
        $oid = $rows["id"];
        $pharmaname = $rows["vendor_name"];
        if ($gethomepage == "" || $gethomepage == "undefined" || $gethomepage == "All") {
            if (isset($_POST["search"])) {
                $searchterm = cleanInput($_POST["search"]);
                $sql = "SELECT * FROM products WHERE owner='$oid' AND name LIKE '%$searchterm%' AND available='On' LIMIT 10";
            } else {
                $sql = "SELECT * FROM products WHERE owner='$oid' AND available='On' AND id > '$lastidloadmore' LIMIT 10";
            }
        } else {
            if (isset($_POST["search"])) {
                $searchterm = cleanInput($_POST["search"]);
                $sql = "SELECT * FROM products WHERE owner='$oid' AND name LIKE '%$searchterm%' AND available='On'";
            } else {

                if ($sub != null) {
                    $sql = "SELECT * FROM products WHERE owner='$oid' AND category='$gethomepage' AND available='On' AND id > '$lastidloadmore'";
                } else {
                    $sql = "SELECT * FROM products WHERE owner='$oid' AND category='$gethomepage' AND available='On' AND subcategory='$sub' AND id > '$lastidloadmore'";
                }
            }
        }
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row["pharmaname"] = $pharmaname;
                $data[] = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "No Product";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No pharmancy near by";
        $data = $row;
    }
}
if (isset($_POST["gethomepage"])) {
    $first_restaurant_lat = cleanInput($_POST["lat"]);
    $sub = cleanInput($_POST["sub"]);
    $gethomepage = cleanInput($_POST["gethomepage"]);
    $first_restaurant_lng = cleanInput($_POST["lng"]);
    /*$sqlrun = "SELECT *, ( 6371 * acos( cos( radians('$first_restaurant_lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$first_restaurant_lng') ) + sin( radians('$first_restaurant_lat') ) * sin( radians( lat ) ) ) ) AS distance FROM users WHERE provider_type='Pharmacist' AND GROUP BY distance HAVING distance < 2000 ORDER BY distance ASC LIMIT 1"; */
    $pharmaid = cleanInput($_POST["pharmaid"]);
    if ($pharmaid == 0) {
        $sqlrun = "SELECT * FROM users WHERE provider_type='Pharmacist' AND verified_service_provider='Approved'";
    } else {
        $sqlrun = "SELECT * FROM users WHERE id='$pharmaid'";
    }
    $runresult = $db->query($sqlrun);
    if ($runresult->num_rows > 0) {
        $rows = $runresult->fetch_assoc();
        $oid = $rows["id"];
        $pharmaname = $rows["vendor_name"];
        if ($gethomepage == "" || $gethomepage == "undefined" || $gethomepage == "All") {
            if (isset($_POST["search"])) {
                $searchterm = cleanInput($_POST["search"]);
                $sql = "SELECT * FROM products WHERE owner='$oid' AND name LIKE '%$searchterm%' AND available='On' LIMIT 10";
            } else {
                $sql = "SELECT * FROM products WHERE owner='$oid' AND available='On' LIMIT 10";
            }
        } else {
            if (isset($_POST["search"])) {
                $searchterm = cleanInput($_POST["search"]);
                $sql = "SELECT * FROM products WHERE owner='$oid' AND name LIKE '%$searchterm%' AND available='On'";
            } else {

                if ($sub != null) {
                    $sql = "SELECT * FROM products WHERE owner='$oid' AND category='$gethomepage' AND available='On'";
                } else {
                    $sql = "SELECT * FROM products WHERE owner='$oid' AND category='$gethomepage' AND available='On' AND subcategory='$sub'";
                }
            }

        }
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row["pharmaname"] = $pharmaname;
                $data[] = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "No Product";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "No pharmancy near by";
        $data = $row;
    }
}

if (isset($_POST["gethomepageold"])) {
    $category = cleanInput($_POST["gethomepage"]);
    $filter = cleanInput($_POST["filter"]);
    $user_latitude = cleanInput($_POST["lat"]);
    $user_longitude = cleanInput($_POST["lng"]);
    $sql = "SELECT id, vendor_name, vendor_address, vendor_type, profile_img, lat, lng, vendor_open_time, vendor_close_time, vendor_halal FROM users WHERE type='1' AND profile_img != 'img/default_profile_picture.jpg' AND availability='On' AND vendor_halal='$filter' AND vendor_address != '' ORDER BY ((lat-$user_latitude)*(lat-$user_latitude)) +((lng - $user_longitude)*(lng - $user_longitude)) ASC";
    if ($filter == "all" || $filter == "null") {
        $sql = "SELECT id, vendor_name, vendor_address, vendor_type, profile_img, lat, lng, vendor_open_time, vendor_close_time, vendor_halal FROM users WHERE type='1' AND profile_img != 'img/default_profile_picture.jpg' AND availability='On' ORDER BY ((lat-$user_latitude)*(lat-$user_latitude)) +((lng - $user_longitude)*(lng - $user_longitude)) ASC";
    } else {
        $sql = "SELECT id, vendor_name, vendor_address, vendor_type, profile_img, lat, lng, vendor_open_time, vendor_close_time, vendor_halal FROM users WHERE type='1' AND profile_img != 'img/default_profile_picture.jpg' AND availability='On' AND vendor_halal='$filter' ORDER BY ((lat-$user_latitude)*(lat-$user_latitude)) +((lng - $user_longitude)*(lng - $user_longitude)) ASC";
    }
    /* if($filter == "all"){
	$sql = "SELECT id, vendor_name, vendor_address, vendor_type, profile_img, lat, lng, vendor_open_time, vendor_close_time, vendor_halal, ( 3959 * acos( cos( radians('$user_latitude') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$user_longitude') ) + sin( radians('$user_latitude') ) * sin( radians( lat ) ) ) ) AS distance FROM users WHERE type ='1' availability='On' GROUP BY distance HAVING distance < 2000 ORDER BY distance ASC LIMIT 0, 10";
}else{
	$sql = "SELECT id, vendor_name, vendor_address, vendor_type, profile_img, lat, lng, vendor_open_time, vendor_close_time, vendor_halal, ( 3959 * acos( cos( radians('$user_latitude') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$user_longitude') ) + sin( radians('$user_latitude') ) * sin( radians( lat ) ) ) ) AS distance FROM users WHERE type ='1' AND vendor_halal='$filter' AND availability='On' GROUP BY distance HAVING distance < 2000 ORDER BY distance ASC LIMIT 0, 10";
} */
    /*$sql =  "SELECT id, (6371 * acos (cos (radians($user_latitude))* cos(radians(lat))* cos( radians($user_longitude) - radians(lng) )+ sin (radians($user_latitude) )* sin(radians(lat)))) AS distance FROM products WHERE distance < 10 AND delivery='$category'"; */
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userLat = $row["lat"];
            $UserLng = $row["lng"];
            $unit = "KM";
            $vendorname = mb_strimwidth($row["vendor_name"], 0, 20, "...");
            $row["vendor_name"] = $vendorname;
            $row["userlat"] = $user_latitude;
            $row["userlng"] = $user_longitude;
            $unitz = "K";
            $row["distance"] = getDistance($user_latitude, $user_longitude, $userLat, $UserLng, $unitz);

            $now = new Datetime("now");
            $begintime = new DateTime($row["vendor_open_time"]);
            $endtime = new DateTime($row["vendor_close_time"]);
            $row["vendor_open_time"] = date("g:i a", strtotime($row["vendor_open_time"]));
            $row["vendor_close_time"] = date("g:i a", strtotime($row["vendor_close_time"]));
            if ($now >= $begintime && $now <= $endtime) {
                $row["closed"] = false;
            } else {
                $row["closed"] = true;
            }
            if ($row["distance"] > 10) {
                $far = true;
            } else {
                $far = false;
            }
            if ($far != true) {
                $data[] = $row;
            }

        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Error: " . $sql . "<br>" . $db->error;
        $data = $row;
    }
}
if (isset($_POST["inserttoorders"])) {
    $amounts = cleanInput($_POST["amounts"]);
    $product_id = cleanInput($_POST["product_id"]);
    $product_owner = cleanInput($_POST["product_owner"]);
    $total_price = cleanInput($_POST["total_price"]);
    $order_owner = cleanInput($_POST["order_owner"]);
    $order_date = cleanInput($_POST["order_date"]);
    $delivery_address = cleanInput($_POST["delivery_address"]);

    if ($amounts != "" && $product_id != "" && $product_owner != "" && $total_price != "" && $order_owner != "" && $order_date != "" && $delivery_address != "") {
        $orderssql = "INSERT INTO orders (amounts, product_id, product_owner, total_price, order_owner, order_date, delivery_address, order_status)
		VALUES ('$amounts', '$product_id', '$product_owner', '$total_price', '$order_owner', '$order_date', '$delivery_address', 'New')";

        if ($db->query($orderssql) === TRUE) {
            $row["status"] = "successful";
            $row["message"] = "Your order has been recieved";
            $data = $row;
        } else {
            $row["status"] = "fail";
            $row["message"] = "Error: " . $sql . "<br>" . $db->error;
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "Please fill all the form";
        $data = $row;
    }
}
function getsellerProfile($id)
{
    global $db;
    $id = cleanInput($id);
    $userssql = "SELECT id, firstname, lastname, profile_img FROM users WHERE id='$id'";
    $usersresult = $db->query($userssql);
    if ($usersresult->num_rows > 0) {
        $row = $usersresult->fetch_assoc();
        $usersdata = $row;

    } else {
        $usersdata = 'User not found';
    }
    return json_decode($userdata);
}

if (isset($_POST["viewThisproducts"])) {
    $id = cleanInput($_POST["viewThisproducts"]);
    $productssql = "SELECT * FROM products WHERE id='$id'";
    $productsresult = $db->query($productssql);
    if ($productsresult->num_rows > 0) {
        $row = $productsresult->fetch_assoc();
        $oid = $row["owner"];
        $row["sellerprofile"] = json_decode(getProfile($oid));
        $data = $row;

    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "The record you looking for does not exist";
        $data = $row;
    }
}

if (isset($_POST["inserttoproducts"])) {
    $owner = $authUser["id"];
    $name = cleanInput($_POST["name"]);
    $description = cleanInput($_POST["description"]);
    $price = cleanInput($_POST["price"]);
    $originalprice = cleanInput($_POST["originalprice"]);
    $delivery = null;
    $lat = cleanInput($_POST["lat"]);
    $lng = cleanInput($_POST["lng"]);
    $stock = cleanInput($_POST["stock"]);
    $about = cleanInput($_POST["about"]);
    $precaution = cleanInput($_POST["precaution"]);
    $sideeffect = cleanInput($_POST["sideeffect"]);
    $tip = cleanInput($_POST["tip"]);
    $overview = cleanInput($_POST["overview"]);
    $forgot = cleanInput($_POST["forgot"]);
    $img1 = cleanInput($_POST["picture"]);
    $reqpress = cleanInput($_POST["reqpress"]);
    $faq = cleanInput($_POST["faq"]);
    $addondata = "[]";
    $category = cleanInput($_POST["category"]);
    $subcategory = cleanInput($_POST["subcategory"]);
    $require_prescription = cleanInput($_POST["reqpress"]);
    define('UPLOAD_DIR', 'assets/');

    if (strpos($img1, 'data:image/png;base64,') !== false) {
        $imgtype1 = ".png";
        $img1 = str_replace('data:image/png;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
        $imgtype1 = ".jpg";
        $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    if ($imgtype1 == ".jpg" || $imgtype1 == ".png") {
        $data1 = base64_decode($img1);
        $imgfile1 = UPLOAD_DIR . uniqid() . "1" . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);

        $imgfileurl1 = $itemurl . $imgfile1;
        if ($owner != "" && $name != "" && $description != "" && $price != "" && $imgfileurl1 != "" || $category != "") {
            $productssql = "INSERT INTO products (owner, name, description, addondata, originalprice, price, delivery, picture, lat, lng, stock, available, about, precaution, sideeffect, tip, overview, forgot, faq, category, subcategory require_prescription)
			VALUES ('$owner', '$name', '$description', '$addondata', '$originalprice', '$price', '$delivery', '$imgfileurl1', '$lat', '$lng', '$stock', 'On', '$about', '$precaution', '$sideeffect', '$tip', '$overview', '$forgot', '$faq', '$category', '$subcategory','$require_prescription')";

            if ($db->query($productssql) === TRUE) {
                $row["status"] = "successful";
                $row["message"] = "Your product has been posted successfully";
                $data = $row;
            } else {
                $row["status"] = "fail";
                $row["message"] = "Error: " . $productssql . "<br>" . $db->error;
                $data = $row;
            }
        } else {
            $row["status"] = "fail";
            $row["message"] = "Please fill all the form";
            $data = $row;
        }
    } else {
        $row["status"] = "fail";
        $row["message"] = "For image please use JPG or PNG only";
        $data = $row;
    }
}
if (isset($_POST["chatlist"])) {
    $ownerid = $authUser["id"];
    $sql = "SELECT * FROM chats WHERE owner_one='$ownerid' OR owner_two='$ownerid' ORDER BY id DESC";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["owner_one"] == $ownerid) {
                $userischatingwith = $row["owner_two"];
                $profile = getProfile2($userischatingwith);
                $row["profile_picture"] = getProfilePicture($userischatingwith);
                $row["fullname"] = $profile["firstname"] . ' ' . $profile["lastname"];
            } else {
                $userischatingwith = $row["owner_one"];
                $profile = getProfile2($userischatingwith);
                $row["profile_picture"] = getProfilePicture($userischatingwith);
                $row["fullname"] = $profile["firstname"] . ' ' . $profile["lastname"];
            }
            $chatid = $row["id"];
            $row["human_session_date"] = date("F jS, Y", strtotime($row["session_date"]));
            $row["latest_message"] = getLastmessage($chatid);
            $data[] = $row;
        }
    } else {
        $data["status"] = "empty";
        $data["message"] = "You havent started any chat yet";
    }
}
if (isset($_POST["updateactivechat"])) {
    $chatid = $db->real_escape_string($_POST["updateactivechat"]);
    $lastid = $db->real_escape_string($_POST["lastid"]);
    $sql = "SELECT * FROM chatcontent WHERE chat_thread='$chatid' AND id > '$lastid'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["chat_date"] = date("F j, Y, g:i a", strtotime($row["chat_date"]));
            $data[] = $row;
        }
    } else {
        $data["status"] = "empty";
        $data["message"] = "nothing new";
    }
}
if (isset($_POST["getchatPartnerinfo"])) {
    $id = $db->real_escape_string($_POST["getchatPartnerinfo"]);
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data["fullname"] = substr($row["firstname"] . ' ' . $row["lastname"], 0, 15);
            $data["fullname"] = $data["fullname"] . '...';

            $data["id"] = $row["id"];
        }
    } else {
        $data[] = "";
    }
}
if (isset($_POST["postchat"])) {
    $ownerid = $authUser["id"];
    $chatthread = $db->real_escape_string($_POST["conversationid"]);
    $chatmessage = $db->real_escape_string($_POST["message"]);
    $chatdate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO chatcontent (chat_thread, chat_content, owner, chat_date)
	VALUES ('$chatthread', '$chatmessage', '$ownerid', '$chatdate')";
    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "";
    } else {
        $data["status"] = "fail";
        $data["message"] = "Error: " . $sql . "<br>" . $db->error;
    }
}
if (isset($_POST["deletechat"])) {
    $threadid = $db->real_escape_string($_POST["deletechat"]);
    $sql = "UPDATE chats SET archive='true' WHERE  id='$threadid'";
    if ($db->query($sql) === TRUE) {
        $row["card"] = "green";
        $row["status"] = "Successfull";
        $row["message"] = "The record has been archived successfully";
        $data = $row;
    } else {
        $row["card"] = "red";
        $row["status"] = "Fail";
        $row["message"] = "Error updating record: " . $db->error;
        $data = $row;
    }
}
if (isset($_POST["chat_content"])) {
    $id = $db->real_escape_string($_POST["chat_content"]);
    $sql = "SELECT * FROM chatcontent WHERE chat_thread='$id' ORDER BY id ASC";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $row["chat_date"] = date("F j, Y, g:i a", strtotime($row["chat_date"]));
            $data[] = $row;
        }
    } else {
        $data["status"] = "empty";
    }
}
if (isset($_POST["update_restaurant"])) {
    $ownerid = $authUser["id"];
    $firstname = $db->real_escape_string($_POST["res_name"]);
    $lastname = $db->real_escape_string($_POST["res_address"]);
    $lat = $db->real_escape_string($_POST["res_lat"]);
    $lng = $db->real_escape_string($_POST["res_lng"]);
    $sql = "UPDATE users SET vendor_name='$firstname', vendor_address='$lastname', lat='$lat', lng='$lng' WHERE id='$ownerid'";

    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Account updated successfully";
        $data["firstname"] = $firstname;
        $data["lastname"] = $lastname;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Please try again later";
    }
}
if (isset($_POST["update_account"])) {
    $ownerid = $authUser["id"];
    $firstname = $db->real_escape_string($_POST["update_firstname"]);
    $lastname = $db->real_escape_string($_POST["update_lastname"]);
    $phonenumber = $db->real_escape_string($_POST["update_phonenumber"]);
    $dateee = $db->real_escape_string($_POST["update_dob"]);
    $update_dob = date("Y-m-d", strtotime($dateee));
    $weight = $db->real_escape_string($_POST["update_weight"]);
    $height = $db->real_escape_string($_POST["update_height"]);
    $residentialaddress = cleanInput($_POST["update_residential_address"]);
    $update_profileimage = cleanInput($_POST["update_profileimage"]);
    $gender = cleanInput($_POST["update_gender"]);
    /* $update_weight = $db->real_escape_string($_POST["update_weight"]);
	$update_height = $db->real_escape_string($_POST["update_height"]); */
    $ic_number = $db->real_escape_string($_POST["update_ic_no"]);


    if ($update_profileimage != "") {
        define('UPLOAD_DIR', 'profile_image/');
        $img1 = $_POST["update_profileimage"];
        if (strpos($img1, 'data:image/png;base64,') !== false) {
            $imgtype1 = ".png";
            $img1 = str_replace('data:image/png;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }
        if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
            $imgtype1 = ".jpg";
            $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
            $img1 = str_replace(' ', '+', $img1);
        }

        $data1 = base64_decode($img1);
        $namez = rand(100000, 100000000) . uniqid();
        $namez = md5($namez);
        $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
        $success1 = file_put_contents($imgfile1, $data1);
        $pp = $itemurl . $imgfile1;
    } else {
        $pp = $authUser["profile_img"];
    }

    if ($authUser["type"] == "2") {
        $update_bank_name = $db->real_escape_string($_POST["update_bank_name"]);
        $update_account_number = $db->real_escape_string($_POST["update_account_number"]);
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', bank_name='$update_bank_name', bank_account_number='$update_account_number' WHERE id='$ownerid'";
    } else {
        $sql = "UPDATE users SET firstname='$firstname', profile_img='$pp', lastname='$lastname', phonenumber='$phonenumber', date_of_birth='$dob', ic_number='$ic_number', address='$residentialaddress', height='$height', weight='$weight', date_of_birth='$update_dob', gender='$gender' WHERE id='$ownerid'";
    }
    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Account updated successfully";
        $data["firstname"] = $firstname;
        $data["lastname"] = $lastname;
        $data["date"] = $dob;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Please try again later";
    }
}
if (isset($_POST["myprofile"])) {
    $uid = $authUser["id"];
    $sql = "SELECT * FROM users WHERE id='$uid'";
    $result = $db->query($sql);
    $data;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["password"] = "*********";
        $row["status"] = "success";
        $row["message"] = "User Exist";
        $row["login_token"] = "public";
        $productssql = "SELECT * FROM products WHERE owner='$uid'";
        $productsresult = $db->query($productssql);
        if ($productsresult->num_rows > 0) {
            while ($prow = $productsresult->fetch_assoc()) {
                $row["products"][] = $prow;
            }

        } else {
            $row["products"] = "empty";
        }
        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "This user no longer exist";
        $data = $row;
    }
}
if (isset($_POST["getprofile"])) {
    $visitorid = $authUser["id"];
    $id = $db->real_escape_string($_POST["getprofile"]);
    $userid = $db->real_escape_string($id);
    $sql = "SELECT * FROM users WHERE id='$userid'";
    $result = $db->query($sql);
    $data;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["password"] = "*********";
        $row["status"] = "success";
        $row["message"] = "User Exist";
        $row["login_token"] = "public";
        $productssql = "SELECT * FROM products WHERE owner='$id'";
        $productsresult = $db->query($productssql);
        if ($productsresult->num_rows > 0) {
            $row["products"] = $productsresult->fetch_assoc();
        } else {
            $row["products"] = "empty";
        }

        $data = $row;
    } else {
        $row["status"] = "fail";
        $row["message"] = "This user no longer exist";
        $data = $row;
    }
}
if (isset($_POST["getproject"])) {
    $ownerid = $authUser["id"];
    $projectsql = "SELECT * FROM projects WHERE project_owner ='$ownerid'";
    $result = $db->query($projectsql);
    if ($result->num_rows > 0) {
        $data;
        while ($projectsobject = $result->fetch_assoc()) {
            $data[] = $projectsobject;
        }
    } else {
        $data["status"] = "fail";
        $data["message"] = "User has no project";
    }
}
if (isset($_POST["getprogress"])) {
    $ownerid = $authUser["id"];
    $projectid = $db->real_escape_string($_POST["getprogress"]);
    $progresssql = "SELECT * FROM progress WHERE project_id ='$projectid' AND owner='$ownerid'";
    $result = $db->query($progresssql);
    if ($result->num_rows > 0) {
        $data;
        while ($progresssobject = $result->fetch_assoc()) {
            $data[] = $progresssobject;
        }
    } else {
        $data["status"] = "fail";
        $data["message"] = "User has no project";
    }
}
if (isset($_POST["uploadprofilepicture"])) {
    define('UPLOAD_DIR', 'profile_image/');
    $img1 = $_POST["img"];
    if (strpos($img1, 'data:image/png;base64,') !== false) {
        $imgtype1 = ".png";
        $img1 = str_replace('data:image/png;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    if (strpos($img1, 'data:image/jpeg;base64,') !== false) {
        $imgtype1 = ".jpg";
        $img1 = str_replace('data:image/jpeg;base64,', '', $img1);
        $img1 = str_replace(' ', '+', $img1);
    }
    $data1 = base64_decode($img1);
    $namez = rand(100000, 100000000) . uniqid();
    $namez = md5($namez);
    $imgfile1 = UPLOAD_DIR . uniqid() . $namez . $imgtype1;
    $success1 = file_put_contents($imgfile1, $data1);

    $imgfileurl1 = $itemurl . $imgfile1;
    $ownerid = $authUser["id"];
    $sql = "UPDATE users SET profile_img='$imgfileurl1' WHERE id='$ownerid'";
    if ($db->query($sql) === TRUE) {
        $data["status"] = "success";
        $data["message"] = "Uploaded successfully";
        $data["imgurl"] = $imgfileurl1;
    } else {
        $data["status"] = "fail";
        $data["message"] = "Fail to upload";
        $data["imgurl"] = $imgfileurl1;
    }
}
if (isset($_POST["notification"])) {
    $ownerid = $authUser["id"];
    $sql = "SELECT * FROM notifcations WHERE owner='$ownerid' OR owner='0' ORDER BY id DESC";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $data["status"] = "fail";
        $data["message"] = "No notification";
        echo $ownerid;
    }
}
if (isset($_POST["readnotification"])) {
    $id = $db->real_escape_string($_POST["readnotification"]);
    $ownerid = $authUser["id"];
    $sql = "SELECT * FROM notifcations WHERE id='$id' AND owner='$ownerid' OR id='$id' AND owner='0'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row;
    } else {
        $data["status"] = "fail";
        $data["message"] = "No notification";
        echo $ownerid;
    }
}

if (isset($_POST["topUpDetails"])) {
    $topUpID = $_POST["topUpID"];
    $sql = "SELECT * FROM senangpay WHERE id='$topUpID'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = $row;
    } else {
        $data["status"] = "fail";
        $data["message"] = "No TopUp";
    }
}

if (isset($_POST["transactionDetails"])) {
    $transactionID = $_POST["transactionID"];
    $sql = "SELECT * FROM transaction_history WHERE id='$transactionID'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row["from_user"]=getUserFullName($db,$row["from_user"]);
        $row["to_user"]=getUserFullName($db,$row["to_user"]);
        $data = $row;
    } else {
        $data["status"] = "fail";
        $data["message"] = "No Transaction";
    }
}

function getUserFullName($db,$id)
{
    $sql = "SELECT fullname FROM users WHERE id='$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["fullname"];
    }
    return "";

}

?>