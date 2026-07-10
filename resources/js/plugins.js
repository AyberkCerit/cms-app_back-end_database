import jQuery from "jquery";

window.$ = jQuery;
window.jQuery = jQuery;

import Swal from "sweetalert2";
window.Swal = Swal;

import axios from "axios";


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})


import 'datatables.net';
import 'datatables.net-select';