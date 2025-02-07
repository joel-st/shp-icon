import { createReduxStore, register } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";

// Some default values
const DEFAULT_STATE = {
    entries: false,
};
const DEFAULT_ACTION = {};

const store = createReduxStore("shp-icon/icon-list", {
    reducer(state = DEFAULT_STATE, action = DEFAULT_ACTION) {
        switch (action.type) {
            case "GET_ENTRIES":
                return {
                    ...state,
                    entries: action.entries,
                };
            default:
                return state;
        }
    },

    actions: {
        setState(entries) {
            return {
                type: "GET_ENTRIES",
                entries,
            };
        },
        fetchFromAPI(path) {
            return {
                type: "FETCH_FROM_API",
                path,
            };
        },
    },

    selectors: {
        getEntries(state) {
            return state.entries || [];
        },
    },

    controls: {
        FETCH_FROM_API(action) {
            return apiFetch({ path: action.path }).then(data => data);
        },
    },

    resolvers: {
        *getEntries() {
            const path = "/shp-icon/v1/icons/";
            const entries = yield store.actions.fetchFromAPI(path);
            return store.actions.setState(entries);
        },
    },
});

register(store);
