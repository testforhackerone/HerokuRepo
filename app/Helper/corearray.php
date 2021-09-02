<?php

//User Roles
function userRole($input = null)
{
    $output = [
        USER_ROLE_ADMIN => __('Admin'),
        USER_ROLE_USER => __('User')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

//status type
function statusType($input = null)
{
    $output = [
        STATUS_ACTIVE => __('Active'),
        STATUS_INACTIVE => __('Inactive')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

//User Activity Array
function userActivity($input = null)
{
    $output = [
        USER_ACTIVITY_LOGIN => __('Log In'),
        USER_ACTIVITY_CREATE_WALLET => __('Create Wallet'),
        USER_ACTIVITY_MOVE_COIN => __('Move Coin'),
        USER_ACTIVITY_WITHDRAWAL => __('Withdrawal'),
        USER_ACTIVITY_CREATE_ADDRESS => __('Create Address'),
        USER_ACTIVITY_MAKE_PRIMARY_WALLET => __('Make Wallet Primary'),
        USER_ACTIVITY_PROFILE_IMAGE_UPLOAD => __('Profile Image Upload'),
        USER_ACTIVITY_UPDATE_PASSWORD => __('Update Password')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

function statusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_SUCCESS => __('Active'),
        STATUS_FINISHED => __('Finished'),
        STATUS_SUSPENDED => __('Deactive'),
        STATUS_REJECT => __('Rejected'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function transactionStatusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Pending'),
        STATUS_SUCCESS => __('Accepted'),
        STATUS_FINISHED => __('Finished'),
        STATUS_SUSPENDED => __('Suspended'),
        STATUS_REJECT => __('Rejected'),
        STATUS_DELETED => __('Deleted'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function coinStatusAction($input = null)
{
    $output = [
        STATUS_PENDING => __('Inactive'),
        STATUS_SUCCESS => __('Active'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function transactionType($input = null)
{
    $output = [
        TRANSACTION_TYPE_DEPOSIT => __('Deposit'),
        TRANSACTION_TYPE_WITHDRAWAL => __('Withdrawal')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// SEND FEES TYPE
function sendFeesType($input = null){
    $output = [
        SEND_FEES_FIXED => __('Fixed'),
        SEND_FEES_PERCENTAGE => __('Percentage'),
        SEND_FEES_BOTH => __('Both'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}

// ADDRESS TYPE
function addressType($input = null){
    $output = [
        ADDRESS_TYPE_EMAIL => __('Email'),
        ADDRESS_TYPE_INTERNAL => __('Internal'),
        ADDRESS_TYPE_EXTERNAL => __('External'),
        ADDRESS_TYPE_PAYPAL => __('Paypal'),
        ADDRESS_TYPE_STRIPE => __('Card'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}


function actions($input = null)
{
    $output = [
        ACTION_DASHBOARD_VIEW => __('basic/role.role_dashboard_view'),
        ACTION_USER_VIEW => __('basic/role.role_user_view'),
        ACTION_USER_ADD => __('basic/role.role_user_add'),
        ACTION_USER_EDIT => __('basic/role.role_user_edit'),
        ACTION_USER_DELETE => __('basic/role.role_user_delete'),
        ACTION_USER_PASSWORD_CHANGE => __('basic/role.role_user_pas_change'),
        ACTION_ROLE_VIEW => __('basic/role.role_role_view'),
        ACTION_ROLE_ADD => __('basic/role.role_role_add'),
        ACTION_ROLE_EDIT => __('basic/role.role_role_edit'),
        ACTION_ROLE_DELETE => __('basic/role.role_role_delete'),
        ACTION_DRIVER_VIEW => __('basic/role.role_driver_view'),
        ACTION_DRIVER_ADD => __('basic/role.role_driver_add'),
        ACTION_DRIVER_EDIT => __('basic/role.role_driver_edit'),
        ACTION_DRIVER_DELETE => __('basic/role.role_driver_delete'),
        ACTION_CLIENT_VIEW => __('basic/role.role_client_view'),
        ACTION_CLIENT_ADD => __('basic/role.role_client_add'),
        ACTION_CLIENT_EDIT => __('basic/role.role_client_edit'),
        ACTION_CLIENT_DELETE => __('basic/role.role_client_delete'),
        ACTION_CONTAINER_VIEW => __('basic/role.role_container_view'),
        ACTION_CONTAINER_ADD => __('basic/role.role_container_add'),
        ACTION_CONTAINER_EDIT => __('basic/role.role_container_edit'),
        ACTION_CONTAINER_DELETE => __('basic/role.role_container_delete'),
        ACTION_ADDRESS_VIEW => __('basic/role.role_address_view'),
        ACTION_ADDRESS_ADD => __('basic/role.role_address_add'),
        ACTION_ADDRESS_EDIT => __('basic/role.role_address_Edit'),
        ACTION_ADDRESS_DELETE => __('basic/role.role_address_delete'),
        ACTION_REQUEST_VIEW => __('basic/role.role_request_view'),
        ACTION_REQUEST_ADD => __('basic/role.role_request_add'),
        ACTION_REQUEST_EDIT => __('basic/role.role_request_edit'),
        ACTION_REQUEST_DELETE => __('basic/role.role_request_delete'),
        ACTION_PRICE_VIEW => __('basic/role.role_price_view'),
        ACTION_PRICE_ADD => __('basic/role.role_price_add'),
        ACTION_PRICE_EDIT => __('basic/role.role_price_edit'),
        ACTION_PRICE_DELETE => __('basic/role.role_price_delete'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function months($input=null){
    $output = [
        1 => __('January'),
        2 => __('February'),
        3 => __('Merch'),
        4 => __('April'),
        5 => __('May'),
        6 => __('June'),
        7 => __('July'),
        8 => __('August'),
        9 => __('September'),
        10 => __('October'),
        11 => __('November'),
        12 => __('December'),
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}
function customPages($input=null){
    $output = [
        'faqs' => __('FAQS'),
        't_and_c' => __('T&C')
    ];
    if (is_null($input)) {
        return $output;
    } else {
        return $output[$input];
    }
}



/*********************************************
 *        End Ststus Functions
 *********************************************/