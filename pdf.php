<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// This must be the VERY FIRST LINE (after PHP tag)
require __DIR__.'/vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
include('includes/dbconnection.php');

// PDF Download Handler
if (isset($_POST['download_pdf'])) {
    try {
        // Create PDF instance
        $pdf = new Dompdf();
        
        // Database connection
        $conn = new mysqli("localhost", "root", "", "bpmsdb");
        if ($conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }
        
        // Get orders
        $sql = "SELECT * FROM orders ORDER BY id DESC";
        $result = $conn->query($sql);
        
        // Build HTML content
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial; margin: 0; padding: 20px; }
                h2 { color: #ff4081; text-align: center; margin-bottom: 20px; }
                .report-header { 
                    background-color: #ff9a9e; 
                    color: white; 
                    padding: 10px; 
                    margin-bottom: 20px;
                    text-align: center;
                    font-weight: bold;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-bottom: 20px;
                    font-size: 12px;
                }
                th { 
                    background-color: #f2f2f2; 
                    color: #333; 
                    padding: 10px; 
                    text-align: left; 
                    border-bottom: 2px solid #ddd;
                }
                td { 
                    padding: 8px; 
                    border-bottom: 1px solid #ddd; 
                    vertical-align: top;
                }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .status {
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-weight: bold;
                    font-size: 11px;
                    text-transform: uppercase;
                }
                .success { background-color: #28a745; color: white; }
                .pending { background-color: #ffc107; color: #333; }
                .footer { 
                    margin-top: 30px; 
                    text-align: right; 
                    font-style: italic; 
                    color: #666;
                    font-size: 11px;
                }
                .text-center { text-align: center; }
                .text-right { text-align: right; }
            </style>
        </head>
        <body>
            <div class="report-header">BEAUTY PARLOUR MANAGEMENT SYSTEM</div>
            <h2>ORDERS REPORT</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Product Title</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Payment</th>
                        <th class="text-right">Price</th>
                        <th class="text-center">Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>';
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = strtolower($row['status']);
                $html .= '
                <tr>
                    <td>'.$row['id'].'</td>
                    <td>'.($row['product_id'] ?? 'N/A').'</td>
                    <td>'.$row['product_title'].'</td>
                    <td>'.$row['customer_name'].'</td>
                    <td>'.$row['address'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['payment_method'].'</td>
                    <td class="text-right">₹'.number_format($row['price'], 2).'</td>
                    <td class="text-center"><span class="status '.$statusClass.'">'.$row['status'].'</span></td>
                    <td>'.date('d M Y h:i A', strtotime($row['created_at'])).'</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="10" style="text-align:center;">No orders found</td></tr>';
        }
        
        $html .= '
                </tbody>
            </table>
            <div class="footer">
                Generated on '.date('F j, Y \a\t g:i a').'
            </div>
        </body>
        </html>';
        
        // Load HTML and generate PDF
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        
        // Output PDF
        $pdf->stream('orders_report_'.date('Y-m-d').'.pdf', [
            'Attachment' => true
        ]);
        exit;
        
    } catch (Exception $e) {
        // Log error and show message
        error_log("PDF Generation Error: " . $e->getMessage());
        die("Error generating PDF. Please check error logs.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beauty Parlour Management System | Orders</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .pdf-btn-container {
            text-align: right;
            margin: 20px 0;
        }
        .pdf-btn {
            background: #ff4081;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .pdf-btn:hover {
            background: #e03570;
        }
        .pdf-btn i {
            margin-right: 8px;
        }
    </style>
</head>
<body id="home">
 
    
    <div class="orders-section">
        <h2 class="section-title" style="     display: flex
;
    justify-self: center;">Download Order Report</h2>
        
        <div class="pdf-btn-container">
            <form method="post">
                <button type="submit" name="download_pdf" class="pdf-btn" style="    display: flex
;
    justify-self: center;">
                    <i class="fas fa-file-pdf"></i> Export to PDF
                </button>
            </form>
        </div>
        
        <!-- Your existing order display HTML/PHP here -->
    </div>

    <!-- Your existing JavaScript includes -->
</body>
</html>