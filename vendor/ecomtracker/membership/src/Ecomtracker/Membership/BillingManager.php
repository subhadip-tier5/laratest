<?php namespace Ecomtracker\Membership;

use Ecomtracker\Membership\Models\MembershipPlan;
use Ecomtracker\User\Models\User;
use Ecomtracker\Membership\NMI\Api as NMIApi;
use Ecomtracker\Membership\Exceptions\Membershipexception ;
class BillingManager
{

    /**
     * Change New recurring price immediatelly and update user.
     *
     * @param User $User
     * @param MembershipPlan $MembershipPlan
     * @return bool  changed or not
     * @throws MembershipException If the Membership Plan is not available for user
     */
    public static function ChargeAndSave(User $User, MembershipPlan $MembershipPlan)
    {


        $nmi_customer_vault_id=$User->nmi_customer_vault_id;
        $nmi_api_config=\Config::get('nmi.nmi_api');
        $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);
        $subscriptionData = array(
            'customer_vault_id' => $nmi_customer_vault_id,
            'orderid'  => $User->id,
            'order_description'   => "ECOMTRACKER Membership of userID:".$User->id."",
            'customer_receipt'    => 'true',
            //'start_date'    => date("Ymd")
        );

        if ($nmi_customer_vault_id) {

            $response_charge=self::ChargeUser($User,$MembershipPlan->recurring_price,$MembershipPlan);

            if ($response_charge['response'] == NMIApi::RESPONSE_APPROVED)
            {

                // cancel previous subscription
                if ($User->nmi_subscription_id)
                {
                    $result_remove = $nmi->removeSubscriptionFromPlan($User->nmi_subscription_id, []);
                    $User->nmi_subscription_id="";
                    $User->save();

                }

                // add new subscription

                $result = $nmi->addSubscriptionToPlan($MembershipPlan->nmi_plan_id, $subscriptionData);
                $User->nmi_subscription_id=$result['subscription_id'];
                $User->membership_plan_id=$MembershipPlan->id;
                $User->save();

               return true;


            }
            else
            {
                return false;
            }


        }
        else
        {
            throw new Membershipexception("NMI CustomerVault not set. Update CC data");

        }




    }


    /**
     * Schedule membership plan change on the end of billing cycle
     *
     * @param User $User
     * @param MembershipPlan $MembershipPlan
     * @return bool  changed or not
     * @throws MembershipException
     */
    public static function ScheduleChargeAndSave(User $User, MembershipPlan $MembershipPlan)

    {


        $User->nmi_actions=([  'action'=>'change_membership',
            'change_to_plan_id'=>$MembershipPlan->id,
        ]);
        $User->save();
        return true;
    }




    /**
     * Cancel  membership subscripion immediatelly
     *
     * @param User $User
     * @return bool  canceled or not
     * @throws MembershipException If some error with NMI
     */
    public static  function CancelAndSave(User $User)
    {


        try {
            $nmi_api_config=\Config::get('nmi.nmi_api');
            $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);
            $result_remove = $nmi->removeSubscriptionFromPlan($User->nmi_subscription_id, []);

            // getting Canceled Plan by nmi_plan_id

            $NewPlan=MembershipPlan::where('nmi_plan_id','=','account_suspended')->first();
            $User->nmi_actions="";
            $User->membership_plan_id=$NewPlan->id;
            $User->nmi_subscription_id="";
            $User->save();

            return true;
        }
        catch ( \Ecomtracker\Membership\NMI\Exception $e) {
            $error=$e->getResponse();
            throw new Membershipexception("Error Canceling Subscription '".$error['responsetext']."'");
        }
    }





    /**
     * Update CC infor on CustomerVault record
     *
     */
    public static  function UpdateCC(User $User,array $CCData)
    {

        $nmi_api_config=\Config::get('nmi.nmi_api');

        $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);


        $customerData = array(
            'first_name' => $CCData['first_name'],
            'last_name'  => $CCData['last_name'],
            'address1'   => $CCData['address1'],
            'country'    => $CCData['country'],
            'city'       => $CCData['city'],
            'state'      => $CCData['state'],
            'zip'        => $CCData['zip'],
            'phone'      => $User->phone,
            'email'      => $User->email,

            'ccnumber' => $CCData['ccnumber'],
            'ccexp'    => $CCData['ccexp_month'].'/'.$CCData['ccexp_year'],
            'cvv'      => $CCData['cvv'],


        );


        try {
            if ($User->nmi_customer_vault_id)
            {
                $result=$nmi->updateCustomer($User->nmi_customer_vault_id, $customerData);
            }
            else
            {
                $result=$nmi->addCustomer( $customerData);
            }
            $User->nmi_customer_vault_id=$result;
            $User->save();


            return true;

        }
        catch ( \Ecomtracker\Membership\NMI\Exception $e) {
            $error=$e->getResponse();
            throw new Membershipexception("Error Updating CC'".$error['responsetext']."'");
        }













    }


    public static function ChargeUser(User $User, $amount, MembershipPlan $MembershipPlan)
    {
        $nmi_customer_vault_id=$User->nmi_customer_vault_id;
        $nmi_api_config=\Config::get('nmi.nmi_api');
        $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);

        $subscriptionData = array(
            'customer_vault_id' => $nmi_customer_vault_id,
            'orderid'  => $User->id,
            'order_description'   => "ECOMTRACKER Membership of userID:".$User->id."",
            'customer_receipt'    => 'true',
            'merchant_defined_field_1'=> $User->id,
            //'start_date'    => date("Ymd")
        );


        $response_charge = $nmi->chargeCustomer($nmi_customer_vault_id, array_merge($subscriptionData,
            [
                'amount'    => $amount,
                'type'      => 'sale',
            ]));

        if ($response_charge['response'] == NMIApi::RESPONSE_APPROVED)
        {
            $date=\Carbon\Carbon::now();
            $User->nmi_last_renewal_date=\Carbon\Carbon::now();
            $date->addDays($MembershipPlan->recurring_period_days);
            $User->nmi_next_charge_date=$date;
            $User->nmi_status='active';

            $User->save();
        }


        return $response_charge;
    }









    public static function NMISyncUsers()
    {
        $Users=User::all();
        foreach ($Users as $User)
        {
            self::NMISyncUser ($User);
        }


    }


    public static function NMISyncUser (User $User)
    {

        $nmi_api_config=\Config::get('nmi.nmi_api');
        $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);



        $start_date=\Carbon\Carbon::parse($User->nmi_last_sync_date);

        $params=['merchant_defined_field_1' => $User->id,
                'start_date' => $start_date->format('YmdHis')
        ];


        //print_r($params);
        $res_log=$nmi->query($params);

        if (count($res_log->transaction)) {
            foreach ($res_log->transaction as $transaction_item) {


                $NMITransaction = new \Ecomtracker\Membership\Models\NMITransaction;
                $NMITransaction->nmi_transaction_id = $transaction_item->transaction_id;
                $NMITransaction->user_id = $User->id;
                $NMITransaction->amount = $transaction_item->action->amount;
                $NMITransaction->success = $transaction_item->action->success;
                $NMITransaction->action_type = $transaction_item->action->action_type;
                $NMITransaction->transaction_date = \Carbon\Carbon::parse($transaction_item->action->date);;

                $NMITransaction->data = $transaction_item;

                $NMITransaction->save();
            }
        }



        $User->nmi_last_sync_date=\Carbon\Carbon::now();
        $User->save();

        self::NMISyncUserChargeDates($User);
        self::NMIProcessUserFailedRebills($User);
    }


    public static function NMISyncUserChargeDates (User $User)
    {
        $latest_charge=$User->NMITransactions()->where("transaction_date",">",$User->nmi_last_renewal_date)->where('success','=','1')->orderBy('id','desc')->first();
        if ($latest_charge)
        {
            $date=\Carbon\Carbon::parse($latest_charge->transaction_date);;
            $User->nmi_last_renewal_date=$date;
            $date->addDays($User->membershipplan->recurring_period_days);
            $User->nmi_next_charge_date=$date;
            $User->nmi_status='active';

            $User->save();
        }
        else
        {
            // no new rebills
        }

    }

    public static function NMIProcessUserFailedRebills (User $User)
    {
        $count_failed_rebills=$User->NMITransactions()->where("transaction_date",">",$User->nmi_next_charge_date)->where('success','!=','1')->orderBy('id','desc')->count();
        if ($count_failed_rebills>=1)
        {

            // move NMI subscrition next charge date
            $date=\Carbon\Carbon::now()->addDays(1);

            $nmi_api_config=\Config::get('nmi.nmi_api');
            $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);


            $params=['start_date' => $date
            ];
            $response_update = $nmi->updateSubscription($User->nmi_subscription_id, $params);


        }
        if ($count_failed_rebills>=3) // more then 3 recharge attempts
        {


            echo '\nToo many recharge attempts. Canceling user';
            try {
                $res_cancel = self::CancelAndSave($User);
            }
            catch (\Exception $ex) {
                echo "\nError Canceling {:".$ex->getMessage();
            }

        }

    }













    public static function ProcessAllMembershipChanges()
    {
        $Users=User::where('nmi_actions','!=','')->where('nmi_status','=','active')->get();
        foreach ($Users as $User)
        {
            self::ProcessUserMembershipChanges ($User);
        }


    }

    public static function ProcessUserMembershipChanges (User $User)
    {

        echo "Processing user $User->id ";
        $nmi_api_config=\Config::get('nmi.nmi_api');
        $nmi = NMIApi::forge($nmi_api_config['username'], $nmi_api_config['password']);

        // check if today it the one day until membership renewal
        $now=\Carbon\Carbon::now();
        $now_plus1=\Carbon\Carbon::now()->addDays(1);
        $recharge_date=\Carbon\Carbon::parse($User->nmi_next_charge_date);


        if ($now_plus1>=$recharge_date)
        {
            echo "Updating user $User->id ";
            print_r($User->nmi_actions);
            if ($User->nmi_actions->action=='change_membership')
            {

                // changing client membership

                $new_plan=MembershipPlan::find($User->nmi_actions->change_to_plan_id);
                try {
                    $res_change = self::ChargeAndSave($User, $new_plan);
                    if (!$res_change)
                    {
                        echo '\nCharge failed. Canceling subscription';
                        try {
                            $res_cancel = self::CancelAndSave($User);
                        }
                        catch (\Exception $ex) {
                            echo "\nError Canceling {:".$ex->getMessage();
                        }

                    }
                }
                catch (\Exception $ex)
                {
                    echo "\nError changing membeship:".$ex->getMessage();
                    echo "\nCanceling subscription";
                    try {
                        $res_cancel = self::CancelAndSave($User);
                    }
                    catch (\Exception $ex) {
                        echo "\nError Canceling {:".$ex->getMessage();
                    }
                }

            }


        }




        $User->nmi_last_sync_date=\Carbon\Carbon::now();
        $User->save();
    }


}