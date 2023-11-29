import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

registerBlockType("wsuwp/az-index", {
    apiVersion: 2,
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
