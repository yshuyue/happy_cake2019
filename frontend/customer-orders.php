


<!DOCTYPE html>
<html lang="en">

<head>

   
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Cake House 帶給你最天然健康的幸福滋味">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz">
    <meta name="keywords" content="">

    <title>
        Cake House : 帶給你最天然健康的幸福滋味
    </title>

    <meta name="keywords" content="">

    <?php require_once('template/head_files.php'); ?>



</head>

<body>
<?php require_once('template/navbar.php'); ?>
<?php require_once('session_check.php'); ?>
<?php
//讀取product_category資料表的所有分類資料
$sql = 'SELECT * FROM customer_orders WHERE memberID='.$_SESSION['member']['memberID'];
$result = $db->query($sql);
$customer_orders = $result->fetchAll(PDO::FETCH_ASSOC);

?>
    <!-- *** NAVBAR END *** -->

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="#">首頁</a>
                        </li>
                        <li>我的訂單</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- *** CUSTOMER MENU ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">會員專區</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="customer-account.php"><i class="fa fa-user"></i> 我的資料</a>
                                </li>
                                <li>
                                    <a href="basket.php"><i class="fa fa-shopping-cart"></i> 我的購物車</a>
                                </li>
                                <li class="active">
                                    <a href="customer-orders.php"><i class="fa fa-list"></i> 我的訂單</a>
                                </li>

                                <li>
                                    <a href="../index.php"><i class="fa fa-sign-out"></i> 登出</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->

                    <!-- *** CUSTOMER MENU END *** -->
                </div>

                <div class="col-md-9" id="customer-orders">
                    <div class="box">
                        <h1>我的訂單</h1>

                        <p class="lead">以下是您的訂單.</p>
                        <p class="text-muted">若有任何問題請至 <a href="contact.php">聯絡我們</a>填寫表單.</p>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>訂單編號</th>
                                        <th>訂購日期</th>
                                        <th>總金額</th>
                                        <th>訂單狀態</th>
                                        <th>訂單明細</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($customer_orders as $customer_order){ ?>
                                    <tr>
                                        <th>#<?php echo $customer_order['order_no']; ?></th>
                                        <td><?php echo $customer_order['order_date']; ?></td>
                                        <td>$ <?php echo $customer_order['total']; ?></td>
                                        <td>
                                        <?php if($customer_order['status'] == 0){ ?>
                                        <span class="label label-info">待付款</span>
                                        <?php }elseif($customer_order['status'] == 1){ ?>
                                        <span class="label label-warning">備貨中</span>
                                        <?php }elseif($customer_order['status'] == 2){ ?>
                                        <span class="label label-warning">運送中</span>
                                        <?php }elseif($customer_order['status'] == 3){ ?>
                                        <span class="label label-success">交易完成</span>
                                        <?php }elseif($customer_order['status'] == 99){ ?>
                                        <span class="label label-danger">取消訂單</span>
                                        <?php } ?>
                                        </td>
                                        <td>
                                        <?php if($customer_order['status'] == 0){ 
                                            $sql2 = 'SELECT * FROM order_details WHERE customer_orderID='. $customer_orders['customer_orderID'];
                                            $result2 = $db->query($sql2);
                                            $order_details = $result->fetchAll(PDO::FETCH_ASSOC);
                                            $items = "";
                                            foreach($order_details as $order_details){
                                                $items .= $order_detail['name']." \$NT".$order_detail['price']."X".$order_detail['quantity']."#";
                                            }
                                            $item_details = substr($items,0, strlen($items)-1);
                                            $order_date = str_replace("-","/",$customer_order['order_date']);
                                            ?>
                                            <form id="formCreditCard" method="post" accept-charset="UTF-8" action="payment_PHP/sample_credit_Credit_CreatOrder.php">
                                                
                                                <input type="hidden" name="MerchantTradeNo" value="<?php echo $customer_order['order_no']; ?>" />
                                              
                                                <input type="hidden" name="MerchantTradeDate" value="<?php echo $order_date; ?>" />
                                                
                                                <input type="hidden" name="PaymentType" value="aio" />
                                                
                                                <input type="hidden" name="TotalAmount" value="<?php echo $customer_order['total']; ?>" />
                                                
                                                <input type="hidden" name="TradeDesc" value="Happy Cake 訂單#<?php echo $customer_order['order_no']; ?> 收件者:<?php echo $customer_order['name']; ?>" /><br />
                                                
                                                <input type="hidden" name="ClientBackURL" value="http://localhost/happy_cake/frontend/customer-orders.php" />
                                                
                                                <input type="hidden" name="customer_orderID" value="<?php echo $customer_order['customer_orderID']; ?>" />
                                                <button type="submit" class="btn label label-danger">去付款</botton>
                                                </form>
                                            
                                        <?php }?>
                                        <a href="order_details.php?orderID="<?php echo $customer_order['customer_orderID']; ?> class="btn btn-primary btn-sm">觀看詳細</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


        <?php require_once('template/footer.php'); ?>



</body>

</html>
