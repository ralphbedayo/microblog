import User from "../models/User";
import {ADMIN_USER_TYPE, SYSTEM_ERROR_MESSAGE} from "../constants/common";

export const AuthUserMixin = {
    data: function () {
        return {
            oAuthUser: {}
        };
    },
    methods: {
        getAuthUser: async function (bIsAdminRequired = false) {
            try {
                let oAuthUser = await User.getAuthUser();

                if (bIsAdminRequired === false && oAuthUser.user_type === ADMIN_USER_TYPE) {
                    window.location.href = '/admin';
                }

                if (bIsAdminRequired === true && oAuthUser.user_type !== ADMIN_USER_TYPE) {
                    window.location.href = '/';
                }

                return oAuthUser;
            } catch (e) {
                alert(SYSTEM_ERROR_MESSAGE);
            }
        }
    }
}

