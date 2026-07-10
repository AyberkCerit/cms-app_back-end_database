// ?
import { Login } from './Pages/Login.js';
import { Register } from './Pages/Register.js';
import { Users } from './Pages/Users.js';
import { BlogCategories } from './Pages/BlogCategories.js';
import { BlogPosts } from './Pages/BlogPosts.js';
import { Languages } from './Pages/Languages.js';
export class Loader {

    constructor() {

    }

    load(ModuleName = "") {


    };

    setModule(ModuleName) {


        if ($(".menu-page").length)
            return true;

        try {
            if (window.app && window.app[ModuleName] !== undefined) {
                window.app[ModuleName].load();
                return
            }

            var cls = this.newclass(ModuleName);
            if (cls != null) {
                if (!window.app) window.app = {};
                window.app[ModuleName] = cls;
                window.app[ModuleName].firstload = true;
                window.app[ModuleName].eventsload = true;
                window.app[ModuleName].dropzone = null;

                this.default_settings();
                return true;
            } else {
                return false;
            }
        } catch (err) {
            console.error(err);
            return false;
        }
    };


    newclass(ModuleName) {
        switch (ModuleName) {
            case "Login":
                return new Login();
            case "Register":
                return new Register();
            case "Users":
                return new Users();
            case "BlogCategories":
                return new BlogCategories();
            case "BlogPosts":
                return new BlogPosts();
            case "Languages":
                return new Languages();
            default:
                return null;
        }
    };

    default_settings() {
        setTimeout(() => {
            $("input:not([autocomplete])").attr("autocomplete", "off");
            $("select:not([autocomplete])").attr("autocomplete", "off");
        }, 1500);
    }

    setConfig() {
        if (this.configset)
            return;


        this.configset = true;

    }
}
