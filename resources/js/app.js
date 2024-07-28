import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import { makeRequest } from "./helpers/requester.js";
import { endpoints } from "./helpers/endpoints";
import { appStore } from "./store";
import { sweetAlert } from "./helpers/alerts.js";
import { showLoader, hideLoader } from "./helpers/loaders";
import { formatDate } from "./helpers/formatters";
import PageTitle from "./views/PageTitle.vue";
import Button from "./components/Button.vue";

import { library } from "@fortawesome/fontawesome-svg-core";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faHand } from "@fortawesome/free-solid-svg-icons";
import {
    faTwitter,
    faFacebook,
    faYoutube,
    faInstagram,
} from "@fortawesome/free-brands-svg-icons";

import "./assets/main.css";
import 'tinymce/tinymce';
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/print';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/anchor';

import 'tinymce/skins/ui/oxide/skin.min.css';
import 'tinymce/skins/ui/oxide/content.min.css';

import App from "./App.vue";
library.add(faTwitter, faFacebook, faYoutube, faInstagram, faHand);
const app = createApp(App);

app.use(router);
app.use(appStore());
app.component("page-title", PageTitle);
app.component("my-button", Button);
app.component("font-awesome-icon", FontAwesomeIcon);
const mixin = {
    data() {
        return {
            endpoints: endpoints(),
        };
    },
    methods: {
        makeRequest,
        sweetAlert,
        showLoader,
        hideLoader,
        formatDate,
    },
};
app.mixin(mixin);

app.mount("#app");
