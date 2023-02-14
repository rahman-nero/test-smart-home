import {createStore} from 'vuex'
import {user} from "@/store/modules/user";
import {mainPage} from "@/store/modules/mainPage";

export default createStore({
    modules: {
        user,
        mainPage
    }
})


