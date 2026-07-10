import axios from "axios";
import Swal from "sweetalert2";

export class Login {
    constructor() {
        this.load();

    };

    load() {
        this.events();




    }

    events() {
        let self = this;
        $('body').on('click', '.loginBtn', function () {
            self.login();

        })


    }

    async login() {
        const { data } = await axios.post("/api/login", {
            email: $(".email").val(),
            password: $(".password").val()
        });
        if (data && data.status) {
            Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
                window.location.href = "/dashboard";
            })
        }
        else {
            Swal.fire('Hata', data.message, 'error');
        }
    }

}