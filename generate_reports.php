<?php
session_start();
include('config.php');
//include('admin-sidebar.php');

require_once('TCPDF/tcpdf.php');

date_default_timezone_set('Asia/Manila');

if(isset($_POST['catAndInven'])){
    $pdf = new TCPDF('p', PDF_UNIT, 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Optimal Optics');
    $pdf->SetTitle('Products');
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $currentTime = date("g:i A");
    $currentDate = date("F j, Y");

    $html_header = '
        <h1 style="text-align: center;">Optimal Optics</h1>
        <p style="text-align: center; line-height: 1;">SM CITY Doña Remedios Trinidad Hwy, Baliuag, Bulacan</p>
        <p style="text-align: center; line-height: 1;"><strong>Catalog and Inventory </strong> Report as of: '.$currentDate. ' ' .$currentTime.'</p>
    ';

    


    $numOfProd = mysqli_query($conn, "SELECT COUNT(*) AS totalProducts FROM addproduct");
    $rowProd = mysqli_fetch_assoc($numOfProd);
    $numOfProd = $rowProd['totalProducts'];

    $html_products = '
        <p style="margin-bottom: 20px;"></p>
        <h3>Available Products ('. $numOfProd .')</h3>
        <table border="0.5" style="padding: 5px;">
            <tr>
                <th style="text-align:center;"><strong>Product ID</strong></th>
                <th style="text-align:center;"><strong>Product Name</strong></th>
                <th style="text-align:center;"><strong>Price</strong></th>
                <th style="text-align:center;"><strong>Description</strong></th>
                <th style="text-align:center;"><strong>Category</strong></th>
                <th style="text-align:center;"><strong>Stocks</strong></th>
            </tr>';

    $result_products = mysqli_query($conn, "SELECT * FROM addproduct");

    while ($row = $result_products->fetch_assoc()) {
        $html_products .= '<tr>';
        $html_products .= '<td style="text-align:center;">' . $row['id'] . '</td>';
        $html_products .= '<td style="text-align:center;">' . $row['name'] . '</td>';
        $html_products .= '<td style="text-align:center;">' . $row['price'] . '</td>';
        $html_products .= '<td style="text-align:center;">' . $row['desc'] . '</td>';
        $html_products .= '<td style="text-align:center;">' . $row['category'] . '</td>';
        $html_products .= '<td style="text-align:center;">' . $row['quantity'] . '</td>';
        $html_products .= '</tr>';
    }

    $html_products .= '</table>';



    $numOfCat = mysqli_query($conn, "SELECT COUNT(*) AS totalCats FROM category");
    $rowCat = mysqli_fetch_assoc($numOfCat);
    $numOfCat = $rowCat['totalCats'];

    $html_categories = '
            <p style="margin-bottom: 20px;"></p>
            <h3>Available Categories ('. $numOfCat .')</h3>
            <table border="0.5" style="padding: 5px;">
            <tr>
            <th style="text-align:center;"><strong>Category</strong></th>
            </tr>';

    $result_categories = mysqli_query($conn, "SELECT * FROM category");

    while ($row = $result_categories->fetch_assoc()) {
        $html_categories .= '<tr>';
        $html_categories .= '<td>' . $row['category'] . '</td>';
        $html_categories .= '</tr>';
    }

    $html_categories .= '</table>';



    $html = $html_header . $html_products . $html_categories;

    $pdf->writeHTML($html);
    $pdf->Output('receipt.pdf', 'I');

    $mysqli->close();
}

if(isset($_POST['patientHistory'])){
    $pdf = new TCPDF('p', PDF_UNIT, 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Optimal Optics');
    $pdf->SetTitle('Patient History');
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $currentTime = date("g:i A");
    $currentDate = date("F j, Y");

    $html_header = '
        <h1 style="text-align: center;">Optimal Optics</h1>
        <p style="text-align: center; line-height: 1;">SM CITY Doña Remedios Trinidad Hwy, Baliuag, Bulacan</p>
        <p style="text-align: center; line-height: 1;"><strong> Patient History </strong>Report as of: '.$currentDate. ' ' .$currentTime.'</p>
    ';

    $result_appointment = mysqli_query($conn, "SELECT * FROM appointments");

    $numOfA = mysqli_query($conn, "SELECT COUNT(*) AS totalA FROM appointments");
    $rowA= mysqli_fetch_assoc($numOfA);
    $numOfA = $rowA['totalA'];

    $numOfAp = mysqli_query($conn, "SELECT COUNT(*) AS totalAp FROM appointments WHERE status = 'approved'");
    $rowAp= mysqli_fetch_assoc($numOfAp);
    $numOfAp = $rowAp['totalAp'];

    $numOfC = mysqli_query($conn, "SELECT COUNT(*) AS totalC FROM appointments WHERE status = 'rejected'");
    $rowC= mysqli_fetch_assoc($numOfC);
    $numOfC = $rowC['totalC'];

    $numOfP = mysqli_query($conn, "SELECT COUNT(*) AS totalP FROM appointments WHERE status = 'pending'");
    $rowP = mysqli_fetch_assoc($numOfP);
    $numOfP = $rowP['totalP'];

    $html_appointment = '
        <p style="margin-bottom: 160px;"> </p>
        <h3>Patient Appointments ('. $numOfA .')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Approved('.$numOfAp.')&nbsp;&nbsp;|&nbsp;&nbsp;Rejected('.$numOfC.')&nbsp;&nbsp;|&nbsp;&nbsp;Pending('.$numOfP.')   </h3>
        <table border="0.5" style="padding: 5px;">
            <tr>
                <th style="text-align: center;">Appointment ID</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Email</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Time</th>
                <th style="text-align: center;">Purpose</th>
                <th style="text-align: center;">Status</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result_appointment)) {
        $html_appointment .= '<tr>';
        $html_appointment .= '<td>' . $row['id'] . '</td>';
        $html_appointment .= '<td>' . $row['name'] . '</td>';
        $html_appointment .= '<td>' . $row['email'] . '</td>';
        $html_appointment .= '<td>' . $row['date'] . '</td>';
        $html_appointment .= '<td>' . $row['time'] . '</td>';
        $html_appointment .= '<td>' . $row['purpose'] . '</td>';
        $html_appointment .= '<td>' . $row['status'] . '</td>';
        $html_appointment .= '</tr>';
    }

    $html_appointment .= '</table>';

    // Combine the HTML code for all tables
    $html = $html_header . $html_appointment ;

    // Output the PDF
    $pdf->writeHTML($html);
    $pdf->Output('patient_history.pdf', 'I');

    // Close the database connection
    $mysqli->close();
}

if(isset($_POST['paymentHistory'])){
    $show =  true;
}

if(isset($_POST['close'])){
    $show =  false;
}

if(isset($_POST['proceed'])){
    $pdf = new TCPDF('p', PDF_UNIT, 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Optimal Optics');
    $pdf->SetTitle('Payments');
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $currentTime = date("g:i A");
    $currentDate = date("F j, Y");

    $html_header = '
        <h1 style="text-align: center;">Optimal Optics</h1>
        <p style="text-align: center; line-height: 1;">SM CITY Doña Remedios Trinidad Hwy, Baliuag, Bulacan</p>
        <p style="text-align: center; line-height: 1;"><strong> Payment History </strong>Report as of: '.$currentDate. ' ' .$currentTime.'</p>
    ';

    // Query for "Online Purchase"
    $result_online_purchase = mysqli_query($conn, "SELECT * FROM payment_history WHERE transactionOrigin = 'Online Purchase' AND orderDate BETWEEN '$_POST[from]' AND '$_POST[to]'");

    $numOfOP = mysqli_query($conn, "SELECT COUNT(DISTINCT transactionID) AS totalOP FROM payment_history  WHERE transactionOrigin = 'Online Purchase' AND orderDate BETWEEN '$_POST[from]' AND '$_POST[to]'");
    $rowOP= mysqli_fetch_assoc($numOfOP);
    $numOfOP = $rowOP['totalOP'];

    $html_online_purchase = '
        <p style="margin-bottom: 30px;"></p>
        <h3>Online Purchase Transactions ('. $numOfOP .')</h3>
        <table border="0.5" style="padding: 5px;">
            <tr>
                <th style="text-align: center;">TransactionID</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Time</th>
                <th style="text-align: center;">Product</th>
                <th style="text-align: center;">Price</th>
                <th style="text-align: center;">Quantity</th>
                <th style="text-align: center;">Total Amount</th>
                <th style="text-align: center;">User</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result_online_purchase)) {
        $html_online_purchase .= '<tr>';
        $html_online_purchase .= '<td>' . $row['transactionID'] . '</td>';
        $html_online_purchase .= '<td>' . $row['orderDate'] . '</td>';
        $html_online_purchase .= '<td>' . $row['time'] . '</td>';
        $html_online_purchase .= '<td>' . $row['product_name'] . '</td>';
        $html_online_purchase .= '<td>' . $row['price'] . '</td>';
        $html_online_purchase .= '<td>' . $row['quantity'] . '</td>';
        $html_online_purchase .= '<td>' . $row['total_amount'] . '</td>';
        $html_online_purchase .= '<td>' . $row['user_id'] . '</td>';
        $html_online_purchase .= '</tr>';
    }

    $html_online_purchase .= '</table>';

    

    // Combine the HTML code for all tables
    $html = $html_header . $html_online_purchase ;

    // Output the PDF
    $pdf->writeHTML($html);
    $pdf->Output('payment_history.pdf', 'I');

    // Close the database connection
    $mysqli->close();
}

if(isset($_POST['customerAccs'])){
    $pdf = new TCPDF('p', PDF_UNIT, 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Optimal Optics');
    $pdf->SetTitle('Account Information');
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->AddPage();

    $currentTime = date("g:i A");
    $currentDate = date("F j, Y");

    $html_header = '
        <h1 style="text-align: center;">Optimal Optics</h1>
        <p style="text-align: center; line-height: 1;">SM CITY Doña Remedios Trinidad Hwy, Baliuag, Bulacan</p>
        <p style="text-align: center; line-height: 1;"><strong> Account Information </strong>Report as of: '.$currentDate. ' ' .$currentTime.'</p>
    ';

    // Query to fetch customer accounts
    $result_accounts = mysqli_query($conn, "SELECT id, name, email, phone_number, e_address, is_blocked FROM user WHERE user_type = 'customer'");

    $numOfCA = mysqli_query($conn, "SELECT COUNT(*) AS totalCA FROM user WHERE user_type = 'customer'");
    $rowCA= mysqli_fetch_assoc($numOfCA);
    $numOfCA = $rowCA['totalCA'];

    $numOfB = mysqli_query($conn, "SELECT COUNT(*) AS totalB FROM user WHERE is_blocked = '1'");
    $rowB= mysqli_fetch_assoc($numOfB);
    $numOfB = $rowB['totalB'];

    $numOfUB = mysqli_query($conn, "SELECT COUNT(*) AS totalUB FROM user WHERE is_blocked = '0'");
    $rowUB = mysqli_fetch_assoc($numOfUB);
    $numOfUB = $rowUB['totalUB'];

    $html_accounts = '
        <p style="margin-bottom: 160px;"> </p>
        <h3>Created Customer Accounts ('. $numOfCA .')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Blocked('.$numOfB.')&nbsp;&nbsp;|&nbsp;&nbsp;Unblocked('.$numOfUB.')   </h3>
        <table border="0.5" style="padding: 5px;">
            <tr>
                <th style="text-align: center;">CustomerID</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">EmailAddress</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">PhoneNumber</th>
                <th style="text-align: center;">Address</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result_accounts)) {
        $html_accounts .= '<tr>';
        $html_accounts .= '<td>' . $row['id'] . '</td>';
        $html_accounts .= '<td>' . $row['name'] . '</td>';
        $html_accounts .= '<td>' . $row['email'] . '</td>';
        $html_accounts .= '<td>' . $row['is_blocked'] . '</td>';
        $html_accounts .= '<td>' . $row['phone_number'] . '</td>';
        $html_accounts .= '<td>' . $row['e_address'] . '</td>';
        $html_accounts .= '</tr>';
    }

    $html_accounts .= '</table>';

    // Combine the HTML code for the table
    $html = $html_header . $html_accounts;

    // Output the PDF
    $pdf->writeHTML($html);
    $pdf->Output('account_information.pdf', 'I');

    // Close the database connection
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: white;
            color: #40596b;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;       
        }

        *{
            font-family: poppins;
        }
        

        .highlight{
            background-color: #334966;
        }

        .buttons{
            background-color: #f89819;
            border:none;
            color: white;
            width: 245px;
            padding: 20px;
            width: 300px;
            font-size: medium;
            border-radius: 10px;
            margin-left: 30px;
            font-weight: 500;
        }

        .con{
            position: absolute;
            left: 560px;
            margin-top: 330px;
        }

        <?php 
            if (isset($show) && $show) {
                echo '.dateFormCon { visibility: visible; }';
            } else {
                echo '.dateFormCon { visibility: hidden; }';
            }
        ?>

        .dateFormCon{
            position: absolute;
            background-color: rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dateForm{
            position: absolute;
            background-color: white;
            padding: 30px;
            width: 300px;
            height: 100px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-container{
            position: fixed;
            width: 300px;
            height: 775px;
            background-color: white;
            box-shadow: 3px 2px 3px 0px rgba(187, 187, 187, 0.5);
            color: #40596b;
        }

        .sidebar-content{
            margin-top: 30px;
            margin-left: 55px;
        }

        a{
            text-decoration: none;
            color: #40596b;
        }

        .link{            
            display: flex;
            margin-top: 18px;
            padding: 2px;
            width: 200px;            
        }

        .link:hover {
        background-color: #f4f4f4;
        }

        .link img{
            margin-right: 15px;
        }

        .logout{
            padding: 2px;
            display: flex;
            margin-top: 40px;
            width: 200px;
            border-radius: 5px;
            align-items: center;            
        }

        .logout:hover {
        background-color: #f4f4f4;
        }

        .logout img{
            margin-right: 15px;
        }

        hr{
            
            height: 2px;
            width: 260px;
            background-color: #d4d4d4;
            border: none;
            margin-top: 30px;
        }

        .profile{
            margin-top: 30px;
            margin-left: 110px;
            
        }

        .hellotxt{
            text-align: center;
        }

        .settings{
            margin-left: 250px;
            margin-top: 20px;
        }

        .sidebar-profile{
            border-radius: 50%;
        }

        .report-container{
            width: 100%;
            height:  100%;
        }

        .text1{
                margin-top: 0px;
                margin-left: 630px;
                position: absolute;
                padding: 10px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
                font-size: 60px;
                background-color: white;
                box-shadow: 0px 2px 3px 0px rgba(187, 187, 187, 0.5);
                color: #f89819;
            }

            #reports{
                background-color: #f4f4f4;
                font-weight: 600;
            }


    </style>
</head>
<body>

    
    <div class= "report-container">
        <h1 class="text1">Generate Reports</h1>
        <div class="con">
        <form method="POST">
            <button class="buttons" name="catAndInven"> Product Inventory </button>
            <button class="buttons" name="patientHistory"> Patient History </button><br> <br>
            <button class="buttons" name="paymentHistory"> Payment History </button>
            <button class="buttons" name="customerAccs"> Customer Accounts </button>
        </form>
        </div>

        <div class="dateFormCon">
        <div class="dateForm">
            <form method="POST">
                <p class="message"> Please select dates.</p>

                <input type="date" max="<?php echo date('Y-m-d')?>" min="2023-12-30" name="from" class="from"> 
                <input type="date" name="to" class="to"> 
                <input type="submit" value="Proceed" name="proceed">
                <input type="submit" value="Close" name="close">
            </form>
        </div>
    </div>

    <div class="sidebar-container">
        <div class="profile">
            <img class="sidebar-profile" src="<?php echo $_SESSION['pImage']; ?>" alt="" height="80px">
        </div>
        <hr>
        <div class="sidebar-content" >
            <div class="link" id="appointments">
                <img src=".\\imagesfinal\schedule.png" alt="" height="23">
                <a href="appointment-management.php">Appointments</a>
            </div>

            <div class="link" id="manageaccounts">
                <img src=".\\imagesfinal\user1.png" alt="" height="21">
                <a href="admin-password2.php" >Manage Accounts</a>
            </div>

            <div class="link" id="category">
                <img src=".\\imagesfinal\category.png" alt="" height="20">
                <a href="category-management.php" >Manage Category</a>
            </div>

            <div class="link" id="product">
                <img src=".\\imagesfinal\box.png" alt="" height="24">
                <a href="add-product.php" >Manage Product</a>
            </div>

            <div class="link" id="manage-ui">
                <img src=".\\imagesfinal\edit.png" alt="" height="21">
                <a href="admin-password.php" >Manage UI</a>
            </div>

            <div class="link">
                <img src=".\\imagesfinal\medical-checkup.png" alt="" height="23">
                <a href="patient-history.php" >Patient History</a>
            </div>
            
            <div class="link">
                <img src=".\\imagesfinal\point-of-sale.png" alt="" height="24">
                <a href="pos.php" >Point of Sale</a>
            </div>

            <div class="link" id="reports">
                <img src=".\\imagesfinal\report.png" alt="" height="22">
                <a href="generate_reports.php" >Reports</a>
            </div>

            <div class="link">
                <img src=".\\imagesfinal\transaction-history1.png" alt="" height="22">
                <a href="payment-history.php" >Payment History</a>
            </div>

            <div class="link">
                <img src=".\\imagesfinal\gear.png" alt="" height="22">
                <a href="admin-account-settings.php" >Settings</a>
            </div>

            <div class="logout">
                <img src=".\\imagesfinal\logout.png" alt="" height="21">
                <a href="?logout" >Logout</a>
            </div>
        </div>
    </div>
    </div>
    

</body>
</html>