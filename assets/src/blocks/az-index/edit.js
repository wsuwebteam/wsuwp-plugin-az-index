const { InspectorControls } = wp.blockEditor;
const { PanelBody, PanelRow, CheckboxControl, SelectControl } = wp.components;

import React, { useState, useEffect } from "react";

import "./styles.scss";

const CSSNAMESPACE = "wsu-gutenberg-az-index";

const linkGroups = [
    "#",
    "A",
    "B",
    "C",
    "D",
    "E",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "N",
    "O",
    "P",
    "Q",
    "R",
    "S",
    "T",
    "U",
    "V",
    "W",
    "X",
    "Y",
    "Z",
];

const aLinks = [
    "A Link to Remember",
    "An Example Link",
    "Another Example Link",
];
const bLinks = [
    "Be a Link to Remember",
    "Bears, Beets, Battlestar Galactica",
    "Build Better Links",
];

export default function Edit(props) {
    const { attributes, setAttributes } = props;

    return (
        <>
            <InspectorControls>
                <PanelBody title="Content Settings" initialOpen={true}>
                    <SelectControl
                        label="Link Group Heading Tag"
                        value={attributes.headingLevel}
                        options={[
                            { label: "H2", value: "h2" },
                            { label: "H3", value: "h3" },
                            { label: "H4", value: "h4" },
                            { label: "H5", value: "h5" },
                            { label: "H6", value: "h6" },
                        ]}
                        onChange={(tag) => setAttributes({ headingLevel: tag })}
                    />

                    <CheckboxControl
                        label="Show All Links"
                        help="All A-Z links will be displayed on the page. Alphabet links and search will not be displayed."
                        checked={attributes.showAllLinks}
                        onChange={(val) => setAttributes({ showAllLinks: val })}
                    />
                </PanelBody>
            </InspectorControls>

            <div className={`${CSSNAMESPACE}`}>
                <div className={`wsu-az-index ${attributes.className || ""}`}>
                    {!attributes.showAllLinks && (
                        <>
                            <div className="wsu-az-index__controls">
                                <nav
                                    className="wsu-az-index__nav"
                                    role="navigation"
                                    aria-label="A-Z Index Navigation"
                                >
                                    <ol className="wsu-az-index__nav-list">
                                        {linkGroups.map((group) => (
                                            <li className="wsu-az-index__nav-item">
                                                <a
                                                    href="#"
                                                    className="wsu-az-index__nav-link wsu-button"
                                                >
                                                    {group}
                                                </a>
                                            </li>
                                        ))}
                                    </ol>
                                </nav>
                                <form className="wsu-az-index__search-form">
                                    <input
                                        type="text"
                                        className="wsu-az-index__search-input"
                                        name="search"
                                        placeholder="Search"
                                    />
                                </form>
                            </div>
                        </>
                    )}

                    <div className="wsu-az-index__link-list-group">
                        <attributes.headingLevel className="wsu-az-index__link-list-heading">
                            A
                        </attributes.headingLevel>
                        <ol className="wsu-az-index__link-list">
                            {aLinks.map((l) => (
                                <li className="wsu-az-index__link-list-item">
                                    <a
                                        href="#"
                                        className="wsu-az-index__link-list-link"
                                    >
                                        {l}
                                    </a>
                                </li>
                            ))}
                            <li className="wsu-az-index__link-list-item">
                                <a
                                    href="#"
                                    className="wsu-az-index__link-list-link"
                                >
                                    &hellip;
                                </a>
                            </li>
                        </ol>
                    </div>

                    {attributes.showAllLinks && (
                        <div className="wsu-az-index__link-list-group">
                            <attributes.headingLevel className="wsu-az-index__link-list-heading">
                                B
                            </attributes.headingLevel>
                            <ol className="wsu-az-index__link-list">
                                {bLinks.map((l) => (
                                    <li className="wsu-az-index__link-list-item">
                                        <a
                                            href="#"
                                            className="wsu-az-index__link-list-link"
                                        >
                                            {l}
                                        </a>
                                    </li>
                                ))}
                                <li className="wsu-az-index__link-list-item">
                                    <a
                                        href="#"
                                        className="wsu-az-index__link-list-link"
                                    >
                                        &hellip;
                                    </a>
                                </li>
                            </ol>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
