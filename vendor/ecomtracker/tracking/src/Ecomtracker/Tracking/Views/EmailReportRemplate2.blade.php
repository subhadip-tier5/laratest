<html>
<body>



<p>Hi {!! $User['firstname']  !!} ,     </p>


<div>Here are the latest product updates from EComTracker::</div>



<div style="width:80%; margin:0 auto ;font-family:arial;" id="email-body">

    <div style="border:1px solid #D1D9E2; border-radius:20px; padding:20px; background:#fff;">



        @foreach ($Products as $Product)


        @if ($Product->status === $Product::STATUS_TRACKED )

                <div style="float:left;margin-right:20px;">
                    <img src="{!! $Product['TrackedData']['parsed_data']->Image !!}" style="max-width:50px;max-height:50px;">
                </div>
                <div>
                    <strong style="font-size:14px; color:#333">
                        {!! $Product['TrackedData']['parsed_data']->Title !!}
                        {!! $Product['title']?("<div>[".$Product['title']."]</div>"):""  !!}
                    </strong>
                    <p style="font-size:12px;">
                        <a target="_blank" title="Click to view Amazon Product Page" href="{!! $Product['TrackedData']['parsed_data']->DetailPageURL !!}">
                            {!! $Product->asin !!}
                        </a>
                        <br>




                        Sales Rank: {!! $Product['TrackedData']['parsed_data']->SalesRank !!}
                        <?php $difference=$Product['TrackedData']['parsed_data']->SalesRank  - $Product['PreviousTrackedData']['parsed_data']->SalesRank  ?>
                        @if ($Product['TrackedData']['parsed_data']->SalesRank and  $Product['PreviousTrackedData']['parsed_data']->SalesRank and $difference<0)
                            <span style="color: #ff0000; font-size: 11px;">+{!! $difference !!}</span>
                        @endif
                        @if ($Product['TrackedData']['parsed_data']->SalesRank and  $Product['PreviousTrackedData']['parsed_data']->SalesRank and $difference>0)
                            <span style="color: #ff0000; font-size: 11px;">-{!! 0-$difference !!}</span>
                        @endif

                        <br>


                        In Stock: {!! $Product['TrackedData']['parsed_data']->InStock !!}
                        <?php $difference=$Product['TrackedData']['parsed_data']->InStock  - $Product['PreviousTrackedData']['parsed_data']->InStock  ?>
                        @if ($Product['TrackedData']['parsed_data']->InStock and  $Product['PreviousTrackedData']['parsed_data']->InStock and $difference>0)
                            <span style="color: #ff0000; font-size: 11px;">+{!! $difference !!}</span>
                        @endif
                        @if ($Product['TrackedData']['parsed_data']->InStock and  $Product['PreviousTrackedData']['parsed_data']->InStock and $difference<0)
                            <span style="color: #ff0000; font-size: 11px;">-{!! 0-$difference !!}</span>
                        @endif


                        <br>

                        Price:

                        {!! $Product['TrackedData']['parsed_data']->LowestNewPrice?"<span class=\"pricenew_products_page\">".$Product['TrackedData']['parsed_data']->LowestNewPrice."<span>(new)</span></span>":"" !!}
                        <?php $difference=str_replace("\$","",$Product['TrackedData']['parsed_data']->LowestNewPrice) - str_replace("\$","",$Product['PreviousTrackedData']['parsed_data']->LowestNewPrice); ?>
                        @if ($Product['TrackedData']['parsed_data']->LowestNewPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestNewPrice and $difference>0)
                            <span style="color: #ff0000; font-size: 11px;">+${!! number_format ($difference,2,'.', ' ') !!}</span>
                        @endif
                        @if ($Product['TrackedData']['parsed_data']->LowestNewPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestNewPrice and $difference<0)
                            <span style="color: #009f3c; font-size: 11px;">-${!! number_format (-$difference,2,'.', ' ') !!}</span>
                        @endif
                        &nbsp;&nbsp;

                        {!! $Product['TrackedData']['parsed_data']->LowestUsedPrice?"<span class=\"pricenew_products_page\">".$Product['TrackedData']['parsed_data']->LowestUsedPrice."<span>(used)</span></span>":"" !!}
                        <?php $difference=str_replace("\$","",$Product['TrackedData']['parsed_data']->LowestUsedPrice) - str_replace("\$","",$Product['PreviousTrackedData']['parsed_data']->LowestUsedPrice); ?>
                        @if ($Product['TrackedData']['parsed_data']->LowestUsedPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestUsedPrice and $difference>0)
                            <span style="color: #ff0000; font-size: 11px;">+${!! number_format ($difference,2,'.', ' ') !!}</span>
                        @endif
                        @if ($Product['TrackedData']['parsed_data']->LowestUsedPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestUsedPrice and $difference<0)
                            <span style="color: #009f3c; font-size: 11px;">-${!! number_format (-$difference,2,'.', ' ') !!}</span>
                        @endif


                        &nbsp;&nbsp;

                        {!! $Product['TrackedData']['parsed_data']->LowestRefurbishedPrice?"<span class=\"pricenew_products_page\">".$Product['TrackedData']['parsed_data']->LowestRefurbishedPrice."<span>(ref.)</span></span>":"" !!}
                        <?php $difference=str_replace("\$","",$Product['TrackedData']['parsed_data']->LowestRefurbishedPrice) - str_replace("\$","",$Product['PreviousTrackedData']['parsed_data']->LowestRefurbishedPrice); ?>
                        @if ($Product['TrackedData']['parsed_data']->LowestRefurbishedPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestRefurbishedPrice and $difference>0)
                            <span style="color: #ff0000; font-size: 11px;">+${!! number_format ($difference,2,'.', ' ') !!}</span>
                        @endif
                        @if ($Product['TrackedData']['parsed_data']->LowestRefurbishedPrice and  $Product['PreviousTrackedData']['parsed_data']->LowestRefurbishedPrice and $difference<0)
                            <span style="color: #009f3c; font-size: 11px;">-${!! number_format (-$difference,2,'.', ' ') !!}</span>
                        @endif






                        <br>
                        Tracked at: {!! $Product['last_processed_at'] !!}


                    </p>
                </div>
                <br>





            <table cellpadding="0" cellspacing="0" style="width:100%; font-family:arial;">
                <thead style="background:#EBEEF0;">
                <tr>
                    <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:70%;">KEYWORDS</th>
                    <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:15%;">RANK</th>
                    <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:15%">POSITION</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($Product['selected_keywords'] as $Keyword)

                <tr>
                    <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">{!! $Keyword['value'] !!}


                    </td>
                    <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">
                        {!! $Keyword['TrackedData']['parsed_data']->product_position !!}
                        <?php $difference_position= str_replace(">","",$Keyword['TrackedData']['parsed_data']->product_position) - str_replace(">","",$Keyword['PreviousTrackedData']['parsed_data']->product_position); ?>
                        @if ($Keyword['TrackedData']['parsed_data']->product_position and  $difference_position>0)
                            <span style="color: #ff0000; font-size: 11px; ">+{!! $difference_position !!}</span>
                        @endif

                        @if ($Keyword['TrackedData']['parsed_data']->product_position and  $difference_position<0)
                            <span style="color: #ff0000; font-size: 11px; ">-{!! -$difference_position !!}</span>
                        @endif



                    </td>
                    <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">

                        {!! $Keyword['TrackedData']['parsed_data']->total_results !!}
                        <?php $difference_total_results= str_replace(">","",$Keyword['TrackedData']['parsed_data']->total_results) - str_replace(">","",$Keyword['PreviousTrackedData']['parsed_data']->total_results); ?>
                        @if ($Keyword['TrackedData']['parsed_data']->total_results and  $difference_total_results>0)
                            <span style="color: #ff0000; font-size: 11px; ">+{!! $difference_total_results !!}</span>
                        @endif

                        @if ($Keyword['TrackedData']['parsed_data']->total_results and  $difference_total_results<0)
                            <span style="color: #ff0000; font-size: 11px; ">-{!! -$difference_total_results !!}</span>
                        @endif





                    </td>
                </tr>
                @endforeach




                </tbody>
            </table>

            <br>
                <table cellpadding="0" cellspacing="0" style="width:100%; font-family:arial;">
                    <thead style="background:#EBEEF0;">
                    <tr>
                        <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:70%;">Product Negative Reviews</th>
                        <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:15%;">Author</th>
                        <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:15%">Stars</th>
                        <th style="padding:5px 0; color:#2c527a; text-align:left; padding:10px; font-size:13px; width:15%">Date</th>


                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($Product['NegativeReviews'] as $NegativeReview)
                            <tr>
                                <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">
                                    <span style="font-family: Helvetica; font-size: 12px; color: #999; ">{!! $NegativeReview['text'] !!}</span>
                                </td>

                                <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">
                                    <i>{!! $NegativeReview['author'] !!}</i>
                                </td>
                                <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0">
                                    {!! $NegativeReview['stars'] !!}
                                </td>
                                <td style="padding:5px 0; color:#333; text-align:left; padding:10px; font-size:13px; border: 1px solid #e0e0e0" nowrap>
                                    {!! $NegativeReview['date'] !!}
                                </td>
                            </tr>



                        @endforeach
                    </tbody>
                </table>

        @endif


        @endforeach









    </div>






    </div>
</div>






</body>
</html>