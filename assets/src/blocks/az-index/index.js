import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

registerBlockType("wsuwp/az-index", {
    title: "A-Z Index",
    icon: "index-card",
    category: "advanced",
    attributes: {
        headingLevel: {
            type: "string",
            default: "h2",
        },
        showAllLinks: {
            type: "boolean",
            default: false,
        },
    },
    edit: Edit,
    save: function () {
        return null;
    },
});
