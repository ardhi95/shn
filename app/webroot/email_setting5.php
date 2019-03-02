<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>DIVERTUNE</title>
		<style>
			/* -------------------------------------
			GLOBAL RESETS
			------------------------------------- */
			
			img
			{
				border: none;
				-ms-interpolation-mode: bicubic;
				max-width: 100%;
				text-decoration:none;
				outline:none;
			}
			
			body
			{
				
				font-family: Helvetica, arial, sans-serif;
				-webkit-font-smoothing: antialiased;
				font-size: 14px;
				line-height: 1.4;
				margin: 0;
				padding: 0; 
				-ms-text-size-adjust: 100%;
				-webkit-text-size-adjust: 100%;
			}
			
			.body
			{
				width: 100%;
				background-color: #ffffff;
			}
			
			.logo
			{
				text-align:center;
				padding-top:20px;
				padding-bottom:20px;
			}
			
			.spacer
			{
				background-color:#ededed;
				height:1px;
			}
			
			.content
			{
				padding:20px;
				font-family: Helvetica, arial, sans-serif;
				font-size: 14px;
			}
			
			.Notif
			{
				font-family: Helvetica, arial, sans-serif;
				font-size: 14px;
				text-align:center;
				vertical-align:middle;
				color:#ffffff;
				height:100px;
				background-color:#666;
				padding:10px;
			}
			
			.ShoppingCart
			{
				font-size: 14px;
				width:100%;
				border-collapse:collapse;
				color:#666766;
			}
			
			.footer
			{
				width:100%;
				display:inline-block;
				float:left;
				background-color:#666; 
				color:#FFF; 
				text-align:center;
				vertical-align:middle;
				min-height:100px !important;
			}
			
			
			
			.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         	.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		 
			@media only screen and (max-width: 480px){
				.content
				{
					font-size:14px !important; line-height:20px !important;
				}
				
				.ShoppingCart
				{
					font-size:14px !important;
				}
			}
        </style>
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" class="body">
            <tr>
            	<td class="logo">
                	<img src="[logo_image_url]" height="50">
                </td>
            </tr>
            <tr>
            	<td class="spacer"></td>
            </tr>
            <tr>
            	<td class="content">
                    Hallo Admin,
                    <br/><br/>
                    Seseorang telah melakukan konfirmasi pembayaran untuk order dengan nomor <b>#[order_no] </b> dengan detil sebagai berikut :
                    <br/>
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-top:20px;" class="ShoppingCart">
                    	<tr style="height:30px;">
                        	<td style="width:150px;">
                            	Order No
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[order_no]
                            </td>
                        </tr>
                        <tr style="height:30px;">
                        	<td style="width:150px;">
                            	Tanggal transfer
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[transfer_date]
                            </td>
                        </tr>
                        <tr style="height:30px;">
                        	<td style="width:150px;">
                            	Bank tujuan
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[destination_bank]
                            </td>
                        </tr>
                        <tr style="height:30px;">
                        	<td style="width:150px;">
                            	Bank asal transfer
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[bank_name]
                            </td>
                        </tr>
                        <tr style="height:30px;">
                        	<td style="width:150px;">
                            	Jumlah transfer
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[amount]
                            </td>
                        </tr>
                        <tr style="height:30px;">
                        	<td style="width:150px;">
                            	Nama pemilik rekening
                            </td>
                            <td style="width:20px;">
                            	:
                            </td>
                            <td style="color:#000;">
                            	[on_behalf]
                            </td>
                        </tr>
                    </table>
                    
                    <div style="width:100%; float:left; display:block;background-color:#ededed; height:1px; margin-top:20px; margin-bottom:60px;">&nbsp;</div>
                    
                    <div class="bank">
                        Hormat Kami,<br /><br />
                        DIVERTUNE<br /><br />
                    </div>
                </td>
            </tr>
        </table>
        <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
            <tr>
                <td class="Notif">
                    Ini adalah notifikasi otomatis. Jangan membalas langsung email ini. Silahkan balas ke [cs_email_address]
                </td>
            </tr>
        </table>
    </body>
</html>