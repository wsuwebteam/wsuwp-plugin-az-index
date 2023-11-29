import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

registerBlockType("wsuwp/az-link", {
    apiVersion: 2,
    title: "Link",
    icon: "admin-links",
    category: "advanced",
    attributes: {
        alt_contact_name: {
            type: "string",
        },
        alt_contact_email: {
            type: "string",
        },
    },
    edit: Edit,
    save: function () {
        return null;
    },
});
