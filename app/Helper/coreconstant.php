<?php


//Answer
const ANSWER_TRUE =1;
const ANSWER_FALSE =0;

//Question type
const MULTIPLE_ANSWER =1;
const TEXT_ANSWER =2;

// Wallet
const WALLET_IS_PRIMARY=1;
const WALLET_IS_NOT_PRIMARY=0;

// Status type
const STATUS_ACTIVE = 1;
const STATUS_INACTIVE = 0;
// ICO
const COIN_IS_ACTIVE=1;
const COIN_IS_NOT_ACTIVE=0;

// Phone Verification
const PHONE_IS_VERIFIED=1;
const PHONE_IS_NOT_VERIFIED=0;

// Address Type
const ADDRESS_TYPE_EMAIL=1;
const ADDRESS_TYPE_INTERNAL=2;
const ADDRESS_TYPE_EXTERNAL=3;
const ADDRESS_TYPE_PAYPAL=4;
const ADDRESS_TYPE_STRIPE=5;

// User Role Type
const USER_ROLE_ADMIN = 1;
const USER_ROLE_USER = 2;

// Send Fees Type
const SEND_FEES_FIXED=1;
const SEND_FEES_PERCENTAGE=2;
const SEND_FEES_BOTH=3;
// Transaction
const TRANSACTION_TYPE_DEPOSIT=1;
const TRANSACTION_TYPE_WITHDRAWAL=2;

// Google Auth Login
const GOOGLE_AUTH_LOGIN_ACTIVE=1;
const GOOGLE_AUTH_LOGIN_DEACTIVE=0;
const GOOGLE_AUTH_ENABLED=1;
const GOOGLE_AUTH_DISABLED=0;

//User Activity
const USER_ACTIVITY_LOGIN=1;
const USER_ACTIVITY_MOVE_COIN=2;
const USER_ACTIVITY_WITHDRAWAL=3;
const USER_ACTIVITY_CREATE_WALLET=4;
const USER_ACTIVITY_CREATE_ADDRESS=5;
const USER_ACTIVITY_MAKE_PRIMARY_WALLET=6;
const USER_ACTIVITY_PROFILE_IMAGE_UPLOAD=7;
const USER_ACTIVITY_UPDATE_PASSWORD=8;

//Photo Id Varification
const USER_PHOTO_ID_SUBMITTED=2;
const USER_PHOTO_ID_APPROVED=1;
const USER_PHOTO_ID_REJECTED=3;
const USER_PHOTO_ID_PENDING=0;

// Paginate
const PAGINATE_SMALL=10;
const PAGINATE_MEDIUM=20;
const PAGINATE_LARGE=50;

const STATUS_PENDING=0;
const STATUS_SUCCESS=1;
const STATUS_SUSPENDED=2;
const STATUS_REJECT=3;
const STATUS_FINISHED=5;
const STATUS_DELETED=6;

const CONTAINER_PICK=1;
const CONTAINER_DELIVERY=2;

const CONTAINER_TYPE_NORMAL=1;
const CONTAINER_TYPE_SPECIAL=2;


const GENDER_MALE=1;
const GENDER_FEMALE=2;

// Actions
const ACTION_DASHBOARD_VIEW = 'action_dashboard_view';
const ACTION_USER_VIEW = 'action_user_view';
const ACTION_USER_ADD = 'action_user_add';
const ACTION_USER_EDIT = 'action_user_edit';
const ACTION_USER_DELETE = 'action_user_delete';
const ACTION_USER_PASSWORD_CHANGE = 'action_user_password_change';

const ACTION_ROLE_VIEW = 'action_role_view';
const ACTION_ROLE_ADD = 'action_role_add';
const ACTION_ROLE_EDIT = 'action_role_edit';
const ACTION_ROLE_DELETE = 'action_role_delete';

const ACTION_DRIVER_VIEW = 'action_driver_view';
const ACTION_DRIVER_ADD = 'action_driver_add';
const ACTION_DRIVER_EDIT = 'action_driver_edit';
const ACTION_DRIVER_DELETE = 'action_driver_delete';

const ACTION_CLIENT_VIEW = 'action_client_view';
const ACTION_CLIENT_ADD = 'action_client_add';
const ACTION_CLIENT_EDIT = 'action_client_edit';
const ACTION_CLIENT_DELETE = 'action_client_delete';

const ACTION_CONTAINER_VIEW = 'action_container_view';
const ACTION_CONTAINER_ADD = 'action_container_add';
const ACTION_CONTAINER_EDIT = 'action_container_edit';
const ACTION_CONTAINER_DELETE = 'action_container_delete';

const ACTION_ADDRESS_VIEW = 'action_address_view';
const ACTION_ADDRESS_ADD = 'action_address_add';
const ACTION_ADDRESS_EDIT = 'action_address_edit';
const ACTION_ADDRESS_DELETE = 'action_address_delete';

const ACTION_REQUEST_VIEW = 'action_request_view';
const ACTION_REQUEST_ADD = 'action_request_add';
const ACTION_REQUEST_EDIT = 'action_request_edit';
const ACTION_REQUEST_DELETE = 'action_request_delete';

const ACTION_PRICE_VIEW = 'action_price_view';
const ACTION_PRICE_ADD = 'action_price_add';
const ACTION_PRICE_EDIT = 'action_price_edit';
const ACTION_PRICE_DELETE = 'action_price_delete';


