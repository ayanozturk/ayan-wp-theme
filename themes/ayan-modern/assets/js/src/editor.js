import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { CheckboxControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
function PostOptionsPanel(){const postType=useSelect((s)=>s('core/editor').getCurrentPostType(),[]);const [meta,setMeta]=useEntityProp('postType',postType,'meta');if(postType!=='post')return null;const featured=meta?._featured_post==='1';const readingTime=meta?._reading_time?String(meta._reading_time):'';return(<PluginDocumentSettingPanel name="ayan-modern-post-options" title={__('Post Options','ayan-modern')} className="ayan-modern-post-options"><CheckboxControl label={__('Mark as featured post','ayan-modern')} checked={featured} onChange={(v)=>setMeta({...meta,_featured_post:v?'1':'0'})}/><TextControl label={__('Reading time (minutes)','ayan-modern')} help={__('Leave empty to auto-calculate from word count.','ayan-modern')} type="number" min={1} max={60} value={readingTime} onChange={(v)=>setMeta({...meta,_reading_time:v?parseInt(v,10):0})}/></PluginDocumentSettingPanel>);}
registerPlugin('ayan-modern-post-options',{render:PostOptionsPanel,icon:null});
