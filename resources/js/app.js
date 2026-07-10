import { Loader } from "./loader";

export class App {

    constructor() {
        setTimeout(() => {
            app.loader = new Loader();
            app.loader.load(this.geturl());
        }, 50);

        this.events();
    };

    events() {

    }

    geturl() {
        let url = window.location.href;
        url = url.replaceAll("#", "").replaceAll("!", "").split(window.location.hostname);
        url = url[1].split('?');
        url = url[0].split('/');

        if (url.length > 1)
            url = url.splice(1, url.length - 1);

        return url;
    }
}

window.app = new App();