<!DOCTYPE html>
<html>
<head>
	<title><?= $title?></title>
</head>
<style type="text/css">
	.m-hidden{
		display: none;
	}
	#service-list table tbody tr td{
		text-align: center;
	}
</style>
<body>
	<div id="list-print">
		<button id="stufforder-btn">In Lệnh đóng/rút hàng</button>
		<button id="contorder-btn">In Lệnh giao nhận container</button>
		<button id="serviceorder-btn">In Lệnh dịch vụ</button>
	</div>
	<div id="stufforder" class="m-hidden">
		<div style="position: relative;top: -8.5vh;left: -3vw; font-size: 0.9em; font-family: 'Arial', 'Sans-serif';">
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 13vw;" class="EIRNo">1234567789</span>
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 44vw;" class="BLNo">SP/18P012304123</span>
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 78.1vw;" class="ExpDate">10/10/2019 20:00</span>
		    <span style="position: absolute;z-index: 1;top: 21.3vh; left: 24vw;" class="Transaction">HA BAI XUẤT TÀU</span>
		    <span style="position: absolute;z-index: 1;top: 21.3vh; left: 66.3vw;" >Hạn điện:&nbsp;<span class="ExpPlugDate">10/10/2019 20:00</span></span>

		    <span style="position: absolute;z-index: 1;top: 27.2vh; left: 16vw;" class="customer">Công ty TNHH Yakjin</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 18.5vw;" class="BookingNo">NTWDSKS1232141</span>
		    <span style="position: absolute;z-index: 1;top: 33.5vh; left: 60vw;" class="Quantity">40</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 79.8vw;" class="DTime">04/03/2019</span>
		    <span style="position: absolute;z-index: 1;top: 36.5vh; left: 16vw;" class="vesselVoy">MEKONG 02/ 111W/111W</span>
		    <span style="position: absolute;z-index: 1;top: 36.8vh; left: 68vw;" class="portMethod">VNITC/KHPNH/KHPNH</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 17vw;font-weight: bold;" class="CntrNo">BMOU1234567</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 38vw;" class="SealNo">NWL011015</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 61.3vw;font-weight: bold;" class="OprID">NWL</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 82.8vw;" class="Status">F</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 17vw;" class="CMDWeight">16</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 38.1vw;font-weight: bold;" class="LocalSZPT">40HC</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 62.3vw;" class="CARGO_TYPE">General</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 19vw;" class="Temperature">30</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 40.1vw;" class="vendors">0.00</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 57vw;" class="UNNO">9</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 79vw;" class="OOG">0.0/0.0/0.0</span>
		    <span style="position: absolute;z-index: 1;top: 61.5vh; left: 23vw;" class="yardPos">B2-04-03-2</span>
		    <span style="position: absolute;z-index: 1;top: 61.5vh; left: 55vw;" class="Remark">some text</span>
		</div>
	</div>
	<div id="contorder" class="m-hidden">
		<div style="position: relative;top: -12.5vh; left: -1.5vw; font-size: 0.9em; font-family: 'Arial', 'Sans-serif';">
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 13vw;" class="EIRNo">1234567789</span>
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 42vw;" class="BLNo">SP/18P012304123</span>
		    <span style="position: absolute;z-index: 1;top: 16.4vh; left: 76.1vw;" class="ExpDate">10/10/2019 20:00</span>
		    <span style="position: absolute;z-index: 1;top: 21.3vh; left: 23vw;" class="Transaction">HA BAI XUẤT TÀU</span>
		    <span style="position: absolute;z-index: 1;top: 21.3vh; left: 64.3vw;" class="yardPosition">HẠN ĐIỆN</span>
		    <span style="position: absolute;z-index: 1;top: 27.2vh; left: 16vw;" class="customer">Công ty TNHH Yakjin</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 18.5vw;" class="BookingNo">NTWDSKS1232141</span>
		    <!-- <span style="position: absolute;z-index: 1;top: 33.5vh; left: 60vw;" class="Quantity">40</span> -->
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 67vw;" class="DTime">04/03/2019</span>
		    <span style="position: absolute;z-index: 1;top: 36vh; left: 16vw;" class="vesselVoy">MEKONG 02/ 111W/111W</span>
		    <span style="position: absolute;z-index: 1;top: 36vh; left: 71.8vw;" class="portMethod">VNITC/KHPNH/KHPNH</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 16.5vw;font-weight: bold;" class="CntrNo">BMOU1234567</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 37.5vw;" class="SealNo">NWL011015</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 61vw;font-weight: bold;" class="OprID">NWL</span>
		    <span style="position: absolute;z-index: 1;top: 44vh; left: 82.8vw;" class="Status">F</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 16vw;" class="CMDWeight">16</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 38vw;font-weight: bold;" class="LocalSZPT">40HC</span>
		    <span style="position: absolute;z-index: 1;top: 49.5vh; left: 61.6vw;" class="CARGO_TYPE">General</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 17vw;" class="Temperature">30</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 39vw;" class="vendors">0.00</span>
		    <span style="position: absolute;z-index: 1;top: 55vh; left: 55.7vw;" class="UNNO">9</span>
		    <span style="position: absolute;z-index: 1;top: 56vh; left: 78.5vw;" class="OOG">0.0/0.0/0.0</span>
		    <span style="position: absolute;z-index: 1;top: 62.2vh; left: 23vw;" class="yardPos">APR01</span>
		    <span style="position: absolute;z-index: 1;top: 62.2vh; left: 51vw;" class="Remark">some text</span>
		</div>
	</div>
	<div id="serviceorder" class="m-hidden">
		<!-- <link href="<?= base_url('/assets/css/main.css')?>" rel="stylesheet" type="text/css"> -->
		<div style="position: relative;top: -7.7vh; left: -3vw; font-size: 0.9em; font-family: 'Arial', 'Sans-serif';">
            <span style="position: absolute;z-index: 1;top: 16.4vh; left: 14.8vw;" class="EIRNo">1234567789</span>
            <span style="position: absolute;z-index: 1;top: 16.8vh; left: 51vw;font-size: 0.8em" class="BLNo">SP/18P012304123</span>
            <span style="position: absolute;z-index: 1;top: 16.4vh; left: 76.1vw;" class="ExpDate">10/10/2019 20:00</span>
            <span style="position: absolute;z-index: 1;top: 21vh; left: 25vw;" class="Transaction">GỞI CONT RỖNG</span>
            <!-- <span style="position: absolute;z-index: 1;top: 20.8vh; left: 65.3vw;" class="yardPosition">Vị trí bãi: E2-37-01-2</span> -->
            <span style="position: absolute;z-index: 1;top: 27.2vh; left: 17vw;" class="customer">Công ty TNHH Yakjin</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 19.5vw;" class="BookingNo">NTWDSKS1232141</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 55vw;" class="Represent">CTY CEH</span>
		    <span style="position: absolute;z-index: 1;top: 31.6vh; left: 79.5vw;" class="telNo">0123456778</span>
		    <!-- <span style="position: absolute;z-index: 1;top: 33.5vh; left: 60vw;" class="Quantity">40</span> -->
		    <span style="position: absolute;z-index: 1;top: 36.3vh; left: 72.3vw;" class="DTime">04/03/2019</span>
		    <span style="position: absolute;z-index: 1;top: 36vh; left: 17vw;" class="vesselVoy">MEKONG 02/ 111W/111W</span>
		    <span style="position: absolute;z-index: 1;top: 41vh; left: 28vw;" class="Remark">some text</span>
		    <div id="service-list" style="text-align: center;position: absolute;z-index: 1 ;height: 13.8vh; width: 85vw; top: 52.2vh; left: 6vw">
		    	<table style="width: 100%;">
		    		<tbody style="width: 100%; font-size: 0.8em;">
		    			<tr style="border: 1px solid">
		    				<td style="width: 3%;height:1.6vh; text-align: center;" class="STT">1</td>
		    				<td style="width: 18%;height:1.6vh; text-align: center;" class="CntrNo">MSCU1234567</td>
		    				<td style="width: 10%;height:1.6vh; text-align: center;" class="OprID">SOC</td>
		    				<td style="width: 8%;height:1.6vh; text-align: center;" class="ISO_SZPT">20GP</td>
		    				<td style="width: 9%;height:1.6vh; text-align: center;" class="Status">E</td>
		    				<td style="width: 10%;height:1.6vh; text-align: center;" class="CMDWeight">20.00</td>
		    				<td style="width: 11%;height:1.6vh; text-align: center;" class="SealNo">123567</td>
		    				<td style="width: 12%;height:1.6vh; text-align: center;" class="yardPos">B2-21-01-1</td>
		    				<td style="width: 16%;height:1.6vh; text-align: center;" class="Remark">this is some text</td>
		    			</tr>
		    		</tbody>
		    	</table>
		    </div>
            <span style="position: absolute;z-index: 1;top: 71vh; left: 12vw;" class="resDate">01/03/2019 08:40</span>
            <span style="position: absolute;z-index: 1;top: 71vh; left: 42vw;" class="startDate">01/03/2019 08:40</span>
            <span style="position: absolute;z-index: 1;top: 71vh; left: 71vw;" class="endDate">01/03/2019 10:40</span>
        </div>
	</div>
</body>
<script type="text/javascript" src="<?= base_url('/assets/js/jquery.min.js');?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#list-print').on('click', 'button', function(){
			switch($(this).attr('id')){
				case 'stufforder-btn':
				PrintElem('stufforder');
				break;
				case 'contorder-btn':
				PrintElem('contorder');
				break;
				case 'serviceorder-btn':
				PrintElem('serviceorder');
				break;
			}
	    });

	    function PrintElem(elem)
	    {
	        var mywindow = window.open('', 'PRINT');

	        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
	        mywindow.document.write('</head><body >');
	        mywindow.document.write(document.getElementById(elem).innerHTML);
	        mywindow.document.write('</body></html>');

	        mywindow.document.close();
	        mywindow.focus();

	        mywindow.print();
	        mywindow.close();

	        return true;
	    }
	});
	
</script>
</html>