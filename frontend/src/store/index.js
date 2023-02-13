import {createStore} from 'vuex'
import {user} from "@/store/modules/user";
import {equipments} from "@/store/modules/equipments";

export default createStore({
    modules: {
        user,
        equipment: equipments
    }
})


