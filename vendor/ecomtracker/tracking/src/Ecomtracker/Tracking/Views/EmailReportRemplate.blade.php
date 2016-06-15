<html>
<body>






<div id="email-body">



    <p>Hi {!! $User['firstname']  !!} ,     </p>


    <div>Here are the latest product updates from EComTracker::</div>

    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ccc; padding: 0 10px;">


        @foreach ($Products as $Product)


        @if ($Product->status === $Product::STATUS_TRACKED )




        <p style="font-family: Helvetica; font-weight: bold; margin: 20px 0 5px 0; text-align: left;">


                <div style="float:left;margin-right:20px;">
                <img src="{!! $Product['TrackedData']['parsed_data']->Image !!}" style="max-width:50px;max-height:50px;">
                </div>
                <div>
                    {!! $Product['TrackedData']['parsed_data']->Title !!}


                    {!! $Product['title']?("<div>[".$Product['title']."]</div>"):""  !!}


                    <div class="asin_products_page">
                        <a target="_blank" title="Click to view Amazon Product Page" href="{!! $Product['TrackedData']['parsed_data']->DetailPageURL !!}">
                            {!! $Product->asin !!}
                        </a>
                    </div>
                </div>





        </p>
        <p style="font-family: Helvetica; font-size: 12px; color: #999; margin: 5px 0 30px 0; text-align: left;">
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



        <table style="width: 100%; font-family: Helvetica; font-size: 12px; border-collapse: collapse; margin-bottom: 70px;">
            <thead>
            <tr>
                <th style="background-color: #eee; padding: 5px 12px;">Keyword</th>
                <th style="background-color: #eee; padding: 5px 12px; text-align: center;">Rank Position</th>
                <th style="background-color: #eee; padding: 5px 12px; text-align: center;">Total Results</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid #eee;">
            @foreach ($Product['selected_keywords'] as $Keyword)

            <tr>
                <td style="border-right: 1px solid #eee; border-left: 1px solid #eee; padding: 5px 12px; text-align: left;">{!! $Keyword['value'] !!}


                </td>
                <td style="border-right: 1px solid #eee; border-left: 1px solid #eee; padding: 5px 12px; text-align: center;">
                    {!! $Keyword['TrackedData']['parsed_data']->product_position !!}
                    <?php $difference_position= str_replace(">","",$Keyword['TrackedData']['parsed_data']->product_position) - str_replace(">","",$Keyword['PreviousTrackedData']['parsed_data']->product_position); ?>
                    @if ($Keyword['TrackedData']['parsed_data']->product_position and  $difference_position>0)
                        <span style="color: #ff0000; font-size: 11px; ">+{!! $difference_position !!}</span>
                    @endif

                    @if ($Keyword['TrackedData']['parsed_data']->product_position and  $difference_position<0)
                        <span style="color: #ff0000; font-size: 11px; ">-{!! -$difference_position !!}</span>
                    @endif



                </td>
                <td style="border-right: 1px solid #eee; border-left: 1px solid #eee; padding: 5px 12px; text-align: center;">

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
                @foreach ($Product['NegativeReviews'] as $NegativeReview)
                    <div><i>{!! $NegativeReview['author'] !!}</i> <span style="font-family: Helvetica; font-size: 12px; color: #999; ">( Rating: {!! $NegativeReview['stars'] !!}, {!! $NegativeReview['date'] !!} )</span>
                        <div>Comments: <br>
                            <span style="font-family: Helvetica; font-size: 12px; color: #999; ">{!! $NegativeReview['text'] !!}</span>
                        </div>
                    </div>
                    <br>

                @endforeach


        @endif


        @endforeach









    </div>
</div>







</body>
</html>