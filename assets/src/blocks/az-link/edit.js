import { RichText } from "@wordpress/block-editor";
import { TextControl, TextareaControl } from "@wordpress/components";
import { useSelect, useDispatch } from "@wordpress/data";

import "./styles.scss";

const CSSNAMESPACE = "wsu-gutenberg-az-link";

export default function Edit(props) {
    let { attributes, setAttributes } = props;

    const postTitle = useSelect((select) => {
        return select("core/editor").getEditedPostAttribute("title");
    });
    const postMeta = useSelect((select) => {
        return select("core/editor").getEditedPostAttribute("meta");
    });
    const { editPost } = useDispatch("core/editor");

    function updateMetaField(key, value) {
        editPost({
            meta: {
                ...postMeta,
                [key]: value,
            },
        });
    }

    return (
        <>
            <div className={CSSNAMESPACE}>
                <div className={`${CSSNAMESPACE}__preview`}>
                    <h1 className={`${CSSNAMESPACE}__post-title`}>
                        <RichText
                            placeholder="Link Name"
                            multiline={false} // prevent linebreaks
                            onReplace={() => {}} // prevent linebreaks
                            onSplit={() => {}} // prevent linebreaks
                            allowedFormats={[]}
                            onChange={(title) => editPost({ title: title })}
                            value={postTitle ? postTitle : ""}
                        />
                    </h1>
                </div>

                <div className={`${CSSNAMESPACE}__editor`}>
                    <div className={`${CSSNAMESPACE}__edit-field`}>
                        <TextControl
                            label="Link URL"
                            className={`${CSSNAMESPACE}__text-control`}
                            placeholder="https://dept.wsu.edu"
                            onChange={(value) =>
                                updateMetaField("wsuwp_az_link_url", value)
                            }
                            value={postMeta.wsuwp_az_link_url}
                        />
                    </div>
                    <div className={`${CSSNAMESPACE}__edit-field`}>
                        <TextareaControl
                            label="Keywords"
                            help="Enter a comma delimited list of words or phrases that you think visitors will use to search for your A-Z Index link. A search function will be added to the A-Z Index in the future. When visitors search using any of your keywords, your link will appear in the results."
                            className={`${CSSNAMESPACE}__text-control`}
                            placeholder="keyword1, keyword2, keyword3"
                            onChange={(value) =>
                                updateMetaField("wsuwp_az_link_keywords", value)
                            }
                            value={postMeta.wsuwp_az_link_keywords}
                        />
                    </div>

                    <h2 className={`${CSSNAMESPACE}__section-title`}>
                        Alternate Contact Information
                    </h2>

                    <div className={`${CSSNAMESPACE}__edit-field`}>
                        <TextControl
                            label="Name"
                            className={`${CSSNAMESPACE}__text-control`}
                            onChange={(val) =>
                                setAttributes({ alt_contact_name: val })
                            }
                            value={attributes.alt_contact_name}
                        />
                    </div>
                    <div className={`${CSSNAMESPACE}__edit-field`}>
                        <TextControl
                            label="Email"
                            className={`${CSSNAMESPACE}__text-control`}
                            onChange={(val) =>
                                setAttributes({ alt_contact_email: val })
                            }
                            value={attributes.alt_contact_email}
                        />
                    </div>
                </div>
            </div>
        </>
    );
}
