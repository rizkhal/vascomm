// components
import * as components from "./components";

export default {
    install(app) {
        // import all components
        for (const componentKey in components) {
            app.use(components[componentKey]);
        }
    },
};
