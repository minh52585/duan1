<?php 

    function viewcart($del){
        global $img_path;
        $tong = 0;
        $i = 0;
        if($del==1){ 
            $xoasp_th = '<th>Thao tác</th>';      
            $xoasp_td2 = '<td></td>';
        }else{
            $xoasp_th = '';
            $xoasp_td2 ='';
        }
        echo '<tr>
                    <th>Hình</th>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    '.$xoasp_th.'
                </tr>';



        foreach($_SESSION['mycart'] as $cart){
            $hinh = $img_path.$cart[2];
            $ttien = $cart[3] * $cart[4];
            $tong+=$ttien;
            if($del==1){ 
                $xoasp_td = '<td><a href="index.php?act=delcart&idcart='.$i.'"><input type="button" value="Xóa" onclick="return confirm(\'Bạn có chắc chắn không?\')"></a></td>';
            }else{
                $xoasp_td = '';
            }
            echo '
                <tr>
                    <td><img src="'.$hinh.'" alt="" height="80px"></td>
                    <td>'.$cart[1].'</td>
                    <td>'.$cart[3].'</td>
                    <td>'.$cart[4].'</td>
                    <td>'.$ttien.'.000 vnđ</td>
                    '.$xoasp_td.'
                </tr>';
            $i+=1;
        }
        echo '<tr>
                <td colspan="4">Tổng đơn hàng</td>
                   
                <td>'.$tong.'.000 vnđ</td>
                '.$xoasp_td2.'
            </tr>';
    }
    function bill_chi_tiet($listbill){
        global $img_path;
        $tong = 0;
        $i = 0;
        
        echo '<tr>
                    <th>Hình</th>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>';



        foreach($listbill as $cart){
            $hinh = $img_path.$cart['img'];
            $tong+=$cart['thanhtien'];
            
            echo '
                <tr>
                    <td><img src="'.$hinh.'" alt="" height="80px"></td>
                    <td>'.$cart['name'].'</td>
                    <td>'.$cart['price'].'</td>
                    <td>'.$cart['soluong'].'</td>
                    <td>'.$cart['thanhtien'].'.000 vnđ</td>
                </tr>';
            $i+=1;
        }
        echo '<tr>
                <td colspan="4">Tổng đơn hàng</td>
                   
                <td>'.$tong.'.000 vnđ</td>
            </tr>';
    }

    function tongdonhang(){
        $tong = 0;
       
        foreach($_SESSION['mycart'] as $cart){
            $ttien = $cart[3] * $cart[4];
            $tong+=$ttien;
            


        }
        return $tong;
    }
    function insert_bill($iduser, $name, $email, $address, $tel, $pttt, $ngaydathang, $tongdonhang){
        $sql = "INSERT INTO bill(iduser, bill_name, bill_email, bill_address, bill_tel, bill_pttt, ngaydathang, total) VALUES('$iduser', '$name', '$email', '$address', '$tel', '$pttt', '$ngaydathang', '$tongdonhang')";
        return pdo_execute_return_lastInsertID($sql);
    }
    function insert_cart($iduser, $idpro, $img, $name, $price, $soluong, $thanhtien, $idbill){
        $sql = "INSERT INTO cart(iduser, idpro, img, name, price, soluong, thanhtien, idbill) VALUES('$iduser', '$idpro', '$img', '$name', '$price', '$soluong', '$thanhtien', '$idbill')";
        return pdo_execute($sql);
    }
    function loadone_bill($id){
        $sql = "SELECT * FROM bill WHERE id = ".$id;
        $bill = pdo_query_one($sql);
        return $bill;
    }
    function loadall_cart($idbill){
        $sql = "SELECT * FROM cart WHERE idbill = ".$idbill;
        $bill = pdo_query($sql);
        return $bill;
    }
    function loadall_cart_count($idbill){
        $sql = "SELECT * FROM cart WHERE idbill = ".$idbill;
        $bill = pdo_query($sql);
        return sizeof($bill);
    }
    function loadall_bill($kyw="", $iduser=0){
        $sql = "SELECT * FROM bill WHERE 1";
        if($iduser>0) $sql.=" AND iduser = ".$iduser;
        if($kyw!="") $sql.=" AND id LIKE '%".$kyw."%'";
        $sql.=" ORDER BY id DESC";
        $listbill = pdo_query($sql);
        return $listbill;
    }
    function get_ttdh($n){
        switch($n){
            case '0':
                $tt = "Đơn hàng mới";
                break;
            case '1':
                $tt = "Đang xử lí";
                break;
            case '2':
                $tt = "Đang giao hàng";
                break;
            case '3':
                $tt = "Hoàn tất";
                break;
            default:
                $tt = "Đơn hàng mới";
                break;
        }
        return $tt;
    }


?>