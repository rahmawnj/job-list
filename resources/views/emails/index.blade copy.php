<body style="background-color:grey">
    <table align="center" border="0" cellpadding="0" cellspacing="0"
           width="550" bgcolor="white" style="border:2px solid black; width:80%;">
        <tbody>
            <tr>
                <td align="center" style="background-color: #8ed9f8;">
                    <table align="center" border="0" cellpadding="0"
                           cellspacing="0" class="col-550" width="550">
                        <tbody>
                            <tr>
                                <td align="center" style="
                                           padding: 20px;">
   
                                    <a href="#" style="text-decoration: none;">
                                        <p style="color:white;
                                                  font-weight:bold;">
                                           <img height="40" src="http://toptalentsconsulting.co.id/Desain-Logo-TTC_LOGO-PANJANG-1.png" alt="" srcset="">
                                        </p>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="padding:20px;">
                <td align="center" style="border: none;
                           border-bottom: 2px solid #8ed9f8; 
                           padding-right: 20px;padding-left:20px">
   
                    <p style="font-weight: bolder;font-size: 42px;
                              letter-spacing: 0.025em;
                              color:black;">
                        <h4>{{$subject}}</h4>
                    </p>
                </td>
            </tr>
   
            <tr style="display: inline-block;">
                <td style="height: 150px;
                           padding: 20px;
                           border: none; 
                           border-bottom: 2px solid #361B0E;
                           background-color: white;">
                     {!! $text !!}
                </td>
            </tr>
            <tr style="border: none; 
            background-color: #8ed9f8; 
            height: 40px; 
            color:white; 
            padding-bottom: 20px; 
            text-align: center;">
                  
<td height="40px" align="center">
    <a href="https://toptalentsconsulting.co.id" 
    style="border:none;
    text-decoration: none;
    color:white;
    padding: 5px;"> 
    {{App\Models\Content::where('name', 'name')->first()->description}}
    </a>
</td>
</tr>

            </tbody></table></td>
        </tr>
       
        </tbody>
    </table>
</body>