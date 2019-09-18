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
			
			.ShoppingCart
			{
				font-size: 14px;
				width:100%;
				border-collapse:collapse;
				color:#666766;
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
			
			.ShoppingCartHeader
			{
				font-weight:bold;
				height:30px;
				border-bottom:1px solid #eeeeee;
			}
			
			.ShoppingCartItem
			{
				font-size: 12px;
				border-bottom:1px solid #eeeeee;
			}
			
			.ShoppingCartItem td
			{
				vertical-align:top;
				padding-top:20px;
				padding-bottom:20px;
				padding-right:10px;
			}
			
			.ShoppingCartFooter
			{
				font-size: 12px;
				height:30px;
			}
			
			.bank
			{
				width:100%;
				display:inline-block;
				float:left;
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
                	Kepada Yth: <strong>[customer_name]</strong>
                    <br/><br/>
                    Ini adalah pemberitahuan bahwa tagihan Anda telah dibuat tanggal [booking_date_time] dengan detail informasi sebagai berikut:
                    <br/>
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; margin-top:20px;" class="ShoppingCart">
                        
                        <tr class="ShoppingCartHeader">
                            <td>
                                BOOKING
                            </td>
                             <td>
                                STUDIO
                            </td>
                            <td style="text-align:right; width:30%;">
                                SUBTOTAL
                            </td>
                        </tr>
                        <tr class="ShoppingCartItem">                 
                            <td>
                                [service_name]<br>
                                [quantity] ([duration])
                            </td>
                            <td>
                               [studio_name]<br>
                               [booking_date]<br>
                               [booking_time_start] - [booking_time_end]
                            </td>
                            <td style="text-align:right; padding-right:0px;">
                                [subtotal]
                            </td>
                        </tr>
                        <tr class="ShoppingCartFooter">
                            <td style="border-bottom:0px;">&nbsp;</td>
                            <td style="border-bottom:1px solid #eeeeee;">Subtotal</td>
                            <td style="text-align:right;border-bottom:1px solid #eeeeee;">[subtotal]</td>
                        </tr>
                        <tr class="ShoppingCartFooter">
                            <td style="border-bottom:0px;">&nbsp;</td>
                            <td style="border-bottom:1px solid #eeeeee;">PPN 10%</td>
                            <td style="text-align:right;border-bottom:1px solid #eeeeee;">[ppn]</td>
                        </tr>
                        <tr class="ShoppingCartFooter">
                            <td style="border-bottom:0px;">&nbsp;</td>
                            <td style="font-weight:bold;border-bottom:1px solid #eeeeee;">TOTAL</td>
                            <td style="text-align:right;font-weight:bold;border-bottom:1px solid #eeeeee;">[total]</td>
                        </tr>
                    </table>
                     <div style="width:100%; float:left; display:block;background-color:#ededed; height:1px; margin-top:50px; margin-bottom:20px;">&nbsp;</div>
                     
                    Mohon lakukan pembayaran Anda dengan cara transfer ke rekening dibawah ini sebesar <b>[total]</b>.<br/><br/>Order anda akan secara otomatis tercancel jika Anda tidak melakukan konfirmasi pembayaran sampai dengan tanggal <b>[due_date_time]</b>
                    [bank_list]
                    
                    <div style="width:100%; float:left; display:block;background-color:#ededed; height:1px; margin-top:20px; margin-bottom:20px;">&nbsp;</div>
                    
                    <div class="bank">
                    	<b>Penting:</b> Mohon lakukan konfirmasi pembayaran pada aplikasi Divertune Anda apabila Anda telah melakukan pembayaran.
                    </div>
                    
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