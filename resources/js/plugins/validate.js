import Vue from "vue";
import { extend, setInteractionMode,} from "vee-validate";
import fr from "vee-validate/dist/locale/fr.json";
import en from "vee-validate/dist/locale/en.json";

import { required, email, alpha_spaces, min, confirmed, numeric } from "vee-validate/dist/rules";

setInteractionMode("eager");

let lang = fr;

// A simple get/set interface to manage our locale in components.
// This is not reactive, so don't create any computed properties/watchers off it.
Object.defineProperty(Vue.prototype, "locale", {
  get() {
    return lang;
  },
  set(val) {
    if (val=='fr')
        lang = fr;
    else
        lang = en;

    extend("required", {
        ...required,
        message: lang.messages.required,
    });

    extend("alpha_spaces", {
        ...alpha_spaces,
        message: lang.messages.alpha_spaces,
    });

    extend("email", {
        ...email,
        message: lang.messages.email
    });

    extend("min", {
        ...min,
        message: lang.messages.min
    });

    extend("confirmed", {
      ...confirmed,
      message: lang.messages.confirmed
    });

    extend("numeric", {
      ...numeric,
      message: lang.messages.numeric
    });
  }
});