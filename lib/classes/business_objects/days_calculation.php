<?php
$objHoliday =new Holiday();
$total_days=$local_holiday=$final_days=0;

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($date1, $interval, $date2);
        foreach ( $period as $dt )
        {
            $day=$dt->format( "l" );
            $date=$dt->format( "m/d/Y" );
            
            if($day=='Saturday' || $day=='Sunday')
            {
                
            }
            else
            {
                $total_days++;
            }   
            
            $holiday_list=array();
            $holiday_list=$objHoliday->GetAllHoliday(" date='".$date."'",array("*"));
            if($holiday_list)
            {
                $local_holiday++;
            }
        
        }
//            echo "Total :".$total_days."<br>";
//            echo "Local :".$local_holiday."<br>";        

            $final_days=$total_days-$local_holiday;
