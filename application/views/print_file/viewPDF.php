<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <!-- jquery ui library -->
<link href="<?=base_url('assets/vendors/jquery-ui/jquery-ui.css');?>" rel="stylesheet" /> 
<script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.js');?>"></script>

<script src="<?= base_url('assets/js/html2pdf.js'); ?>"></script>

<style type="text/css">
	.m-show-modal{
        position:fixed;top:0;left:0;width:100vw;height:100vh;display:none; z-index: 1002
    }
    .m-show-modal .m-modal-background{
        background-color:rgba(0,0,0,0.65);width:100%;height:100%;top:0;left:0;position:absolute;z-index:98
    }
    .m-show-modal .m-modal-content{
        position:absolute;top:0;left:0;width:100%;height:100%;z-index:99
    }
    .m-close-modal{
        position: fixed;
        z-index: 100;
        top: 7px;
        left: 55px;
        color: #fff;
        cursor: pointer;
    }
    .m-close-modal i{
        padding: 5px;
        border-radius: 4px;
    }

    .m-close-modal i:hover{
        background-color: #838482;
    }

    .dropdown-item {
        padding: .95rem 3.5rem!important;
    }
    .btn.dropdown-arrow:after{
        left: .7rem!important;
    }
</style>
<html>
  <head>
      <meta http-equiv="Content-Type"  content="aplication/pdf; charset=utf-8"/>
      <meta name="content-disposition" content="inline; filename=openinexcel.pdf">
      <title><?=$title;?></title>
      <style>
         body { font-family: DejaVu Sans, sans-serif; }
         #detail-table td{ border: solid #bbb; border-width: 1px 1px 0px 0px; }
      </style>
  </head>
<body></body>
</html>
<div class="m-show-modal">
    <div class="m-modal-background">
    </div>
    <div class="m-modal-content">
        <embed id="file-show-content" width="100%" height="100%" type="application/pdf" ></embed>
    </div>
</div>
<script >
	window.onload = function()
	{
        $('.m-show-modal').show('fade');
	    test();
	};

	function test() {
	    // Get the element.
	    var element = `<?= $htmlString; ?>`;
	    // Generate the PDF.
	    html2pdf().from(element).set({
	      margin: 0.3,
	      filename: 'test.pdf',
	      html2canvas: { scale: 1.5 },
	      jsPDF: {orientation: 'portrait', unit: 'in', format: 'a4', compressPDF: true}
	    }).outputPdf().then(function(e){
	      	$('#file-show-content').attr( 'src', "data:application/pdf;base64, " + btoa(e) );
	    });
	}
</script>