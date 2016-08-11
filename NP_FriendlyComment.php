<?php
class NP_FriendlyComment extends NucleusPlugin {
    function getName()        { return 'Friendly Comment';}
    function getAuthor()      { return 'Lord Matt';}
    function getURL()         { return 'https://github.com/NucleusCMS/NP_FriendlyComment';}
    function getVersion()     { return '1.1';}
    function getDescription() { return 'Stops data being brashly shown (such as email adresses).';}
    function getEventList()   { return array('PreComment');}
    
    function event_PreComment(&$data){
        global $manager;
        
        $pos = strpos($data['comment']['userlinkraw'], '@');
        if ($pos === false) return;
        
        $created = false;
        $url = '';
        $params = array();
        $params['type']      = 'item';
        $params['params']    = array('itemid'=>$data['comment']['itemid'], 'blogid'=>$data['comment']['blogid']);
        $params['completed'] = &$created;
        $params['url']       = &$url;
        $manager->notify('GenerateURL',$params);
        $data['comment']['userlinkraw'] = $url . '#' . $data['commentid'];
    }
}