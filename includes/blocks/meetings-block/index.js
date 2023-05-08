(()=>{"use strict";const e=window.wp.blocks,t=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"tsmlxtras/meetings-block","title":"Meeting Blocks","category":"embed","icon":"groups","attributes":{"blockType":{"type":"string","default":"tsml_ui"},"showCount":{"type":"boolean","default":true}},"supports":{"html":false,"align":true,"anchor":true,"className":true,"color":{"link":true,"background":true,"text":true},"typography":{"fontSize":true,"__experimentalFontStyle":true,"__experimentalFontWeight":true,"__experimentalTextTransform":true,"__experimentalDefaultControls":{"fontSize":true,"fontAppearance":true,"textTransform":true}}},"textdomain":"tsmlxtras-meetings-block","render":"file:./render.php","editorScript":"file:./index.js","editorStyle":"file:../../../assets/css/main.css"}'),l=window.wp.element,n=window.wp.blockEditor,s=window.wp.components,o=window.wp.i18n;const r=function(e){e.attributes.blocktype;var t=e.setAttributes,r=wp.serverSideRender;return(0,l.createElement)("div",(0,n.useBlockProps)(),(0,l.createElement)(n.InspectorControls,null,(0,l.createElement)(s.Panel,null,(0,l.createElement)(s.PanelBody,{title:(0,o.__)("Block Settings","tsmlxtras-meetings-block"),icon:"admin-plugins"},(0,l.createElement)(s.SelectControl,{label:"Select Block Type",value:e.attributes.blockType,options:[{label:"Meetings UI",value:"tsml_ui"},{label:"Next Meetings",value:"tsml_next_meetings"},{label:"Types List",value:"tsml_types_list"},{label:"Regions List",value:"tsmlx_get_regions_list"},{label:"Xtras Meeing Table",value:"tsmlx"}],onChange:function(e){return t({blockType:e})}}),(0,l.createElement)(s.CheckboxControl,{label:"Show Count of Meetings (where applicable)",checked:e.attributes.showCount,onChange:function(e){return t({showCount:e})}})))),"tsml_ui"==e.attributes.blockType&&(0,l.createElement)(s.Placeholder,{icon:(0,l.createElement)(n.BlockIcon,{icon:"groups",size:"50"}),label:(0,o.__)("12 Step Meeting List Xtras blocks","tsmlxtras-meetings-block"),instructions:(0,o.__)("Some blocks will not render in the editor. View the page to see the block.","tsmlxtras-meetings-block")}),(0,l.createElement)(r,{block:"tsmlxtras/meetings-block",attributes:e.attributes}))};(0,e.registerBlockType)(t,{edit:r})})();