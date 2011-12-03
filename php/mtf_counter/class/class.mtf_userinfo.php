<?php
/**
 * @author Thorsten Hillebrand
 * @version 31.03.2005
 */
class MTF_Userinfo {
	var $strOperatingSystem;
	var $strBrowser;
	var $strBrowserVersion;
	var $strCountry;
	var $strLanguage;
	
	var $strSESSION_ID;
	var $strREMOVE_ADDR;
	var $strREMOVE_HOST;
	var $strHTTP_USER_AGENT;
	var $strHTTP_ACCEPT_LANGUAGE;
	var $strQUERY_STRING;
	var $strHTTP_REFERER;
	var $strPHP_SELF;
	

	function MTF_Userinfo() {
		$this->strREMOVE_ADDR = $_SERVER["REMOTE_ADDR"];
		$this->strREMOVE_HOST = $_SERVER["REMOTE_HOST"];
		$this->strHTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
		$this->strHTTP_ACCEPT_LANGUAGE = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$this->strSESSION_ID = session_id();
		$this->strQUERY_STRING = $_SERVER["QUERY_STRING"];
		$this->strHTTP_REFERER = $_SERVER["HTTP_REFERER"];
		$this->strPHP_SELF = $_SERVER["PHP_SELF"];
		
		
		//-------------------------------------
		// Operation System
		//------------------------------------- 
		if (ereg("linux", $this->strHTTP_USER_AGENT) || ereg("Linux", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Linux";
		}
		elseif (ereg("unix", $this->strHTTP_USER_AGENT) || ereg("Unix", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Unix";
		}
		elseif (ereg("SunOS", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "SunOS";
		}
		elseif (ereg("FreeBSD", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "FreeBSD";
		}
		elseif (ereg("NetBSD", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "NetBSD";
		}
		elseif (ereg("AIX", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "AIX";
		}
		elseif (ereg("IRIX", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "IRIX";
		}
		elseif (ereg("HP-UX", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "HP-UX";
		}
		elseif (ereg("OS/2", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "OS/2";
		}
		elseif (ereg("Mac PowerPC", $this->strHTTP_USER_AGENT) || ereg("Mac_PowerPC", $this->strHTTP_USER_AGENT) || ereg("Mac PPC", $this->strHTTP_USER_AGENT) || ereg("PPC", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Mac PPC";
		}
		elseif (ereg("BeOS", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "BeOS";
		}
		elseif (ereg("Curl", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Curl";
		}
		elseif (ereg("AmigaOS", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "AmigaOS";
		}
		elseif (ereg("Windows 95", $this->strHTTP_USER_AGENT) || ereg("Win95", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows 95";
		}
		elseif (ereg("Windows 98", $this->strHTTP_USER_AGENT) || ereg("Win98", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows 98";
		}
		elseif (ereg("Win 9x", $this->strHTTP_USER_AGENT) || ereg("Win9x", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows 9x";
		}
		elseif (ereg("Win 9x 4.90", $this->strHTTP_USER_AGENT) || ereg("Windows ME", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows ME";
		}
		elseif (ereg("Windows NT 5.0", $this->strHTTP_USER_AGENT) || ereg("Windows NT5.0", $this->strHTTP_USER_AGENT) || ereg("Windows 2000", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows 2000";
		}
		elseif (ereg("Windows NT 5.1", $this->strHTTP_USER_AGENT) || ereg("Windows NT5.1", $this->strHTTP_USER_AGENT) || ereg("Windows XP", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows XP";
		}
		elseif (ereg("Windows 32", $this->strHTTP_USER_AGENT) || ereg("Windows32", $this->strHTTP_USER_AGENT) || ereg("Win32", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Win32";
		}
		elseif (ereg("Windows NT", $this->strHTTP_USER_AGENT) || ereg("WindowsNT", $this->strHTTP_USER_AGENT) || ereg("WinNT", $this->strHTTP_USER_AGENT)) {
			$this->strOperatingSystem = "Windows NT";
		} 
		else {
			$this->strOperatingSystem = "unknown";
		}
		
		//---------------------------------------
		// Language, Country
		//---------------------------------------
		 $tmp = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		 $tmp = explode(";", $tmp[0]);
		 if(strlen($tmp[0]) == "5") {
		 	 $tmp = substr($tmp[0], 3, 2);
		 }
		 elseif(strlen($tmp[0]) == "2") {
		 	 $tmp = $tmp[0];
		 }
		 else {
		 	 $tmp = "unknown";
		 }
		 
		 switch($tmp) {
		 	 case "af": $result = array("af", "Afghanistan"); break;
		 	 case "eg": $result = array("eg", "&Auml;gypten"); break;
		 	 case "ax": $result = array("ax", "Aland"); break;
		 	 case "al": $result = array("al", "Albanien"); break;
		 	 case "dz": $result = array("dz", "Algerien"); break;
		 	 case "um": $result = array("um", "Amerikanisch-Ozeanien"); break;
		 	 case "as": $result = array("as", "Amerikanisch-Samoa"); break;
		 	 case "vi": $result = array("vi", "Amerikanische Jungferninseln"); break;
		 	 case "ad": $result = array("ad", "Andorra"); break;
		 	 case "ao": $result = array("ao", "Angola"); break;
		 	 case "ai": $result = array("ai", "Anguilla"); break;
		 	 case "aq": $result = array("aq", "Antarktis"); break;
		 	 case "ag": $result = array("ag", "Antigua und Barbuda"); break;
		 	 case "gq": $result = array("gq", "&Auml;quatorialguinea"); break;
		 	 case "ar": $result = array("ar", "Argentinien"); break;
		 	 case "am": $result = array("am", "Armenien"); break;
		 	 case "aw": $result = array("aw", "Aruba"); break;
		 	 case "ac": $result = array("ac", "Ascension"); break;
		 	 case "az": $result = array("az", "Aserbaidschan"); break;
		 	 case "et": $result = array("et", "&Auml;thiopien"); break;
		 	 case "au": $result = array("au", "Australien"); break;
		 	 case "bs": $result = array("bs", "Bahamas"); break;
		 	 case "bh": $result = array("bh", "Bahrain"); break;
		 	 case "bd": $result = array("bd", "Babgladesch"); break;
		 	 case "bb": $result = array("bb", "Barbados"); break;
		 	 case "by": $result = array("by", "Belarus"); break;
		 	 case "be": $result = array("be", "Belgien"); break;
		 	 case "bz": $result = array("bz", "Belize"); break;
		 	 case "bj": $result = array("bj", "Benin"); break;
		 	 case "bm": $result = array("bm", "Bermuda"); break;
		 	 case "bt": $result = array("bt", "Bhutan"); break;
		 	 case "bo": $result = array("bo", "Bolivien"); break;
		 	 case "ba": $result = array("ba", "Bosnien und Herzegowina"); break;
		 	 case "bw": $result = array("bw", "Botswana"); break;
		 	 case "bv": $result = array("bv", "Bouvetinsel"); break;
		 	 case "br": $result = array("br", "Brasilien"); break;
		 	 case "vg": $result = array("vg", "Britische Jungferninseln"); break;
		 	 case "io": $result = array("io", "Britisches Territorium im Indischen Ozean"); break;
		 	 case "bn": $result = array("bn", "Brunei Darussalam"); break;
		 	 case "bg": $result = array("bg", "Bulgarien"); break;
		 	 case "bf": $result = array("bf", "Burkina Faso"); break;
		 	 case "bu": $result = array("bu", "Myanmar (fr&uuml;her Burma)"); break;
		 	 case "bi": $result = array("bi", "Burundi"); break;
		 	 case "ea": $result = array("ea", "Ceuta, Melilla"); break;
		 	 case "cl": $result = array("cl", "Chile"); break;
		 	 case "cn": $result = array("cn", "China"); break;
		 	 case "cp": $result = array("cp", "Clipperton"); break;
		 	 case "ck": $result = array("ck", "Cookinseln"); break;
		 	 case "cr": $result = array("cr", "Costa Rica"); break;
		 	 case "ci": $result = array("ci", "Elfenbeink&uuml;ste"); break;
		 	 case "dk": $result = array("dk", "D&auml;nemark"); break;
		 	 case "de": $result = array("de", "Deutschland"); break;
		 	 case "dg": $result = array("dg", "Diego Garcia"); break;
		 	 case "dm": $result = array("dm", "Dominica"); break;
		 	 case "do": $result = array("do", "Dominikanische Republik"); break;
		 	 case "dj": $result = array("dj", "Dschibuti"); break;
		 	 case "ec": $result = array("ec", "Ecuador"); break;
		 	 case "sv": $result = array("sv", "El Salvador"); break;
		 	 case "er": $result = array("er", "Eritrea"); break;
		 	 case "ee": $result = array("ee", "Estland"); break;
		 	 case "eu": $result = array("eu", "Europ&auml;ische Union"); break;
		 	 case "fk": $result = array("fk", "Falklandinseln"); break;
		 	 case "fo": $result = array("fo", "F&auml;r&ouml;er"); break;
		 	 case "fj": $result = array("fj", "Fidischi"); break;
		 	 case "fi": $result = array("fi", "Finnland"); break;
		 	 case "fr": $result = array("fr", "Frankreich"); break;
		 	 case "fx": $result = array("fx", "Frankreich, Metropolitan"); break;
		 	 case "gf": $result = array("gf", "Franz&ouml;sisch-Guayana"); break;
		 	 case "pf": $result = array("pf", "Franz&ouml;sisch-Polynesien"); break;
			 case "tf": $result = array("tf", "Franz&ouml;sische S&uuml;d- und Antaktisgebiete"); break;
		 	 case "ga": $result = array("ga", "Gabun"); break;
		 	 case "gm": $result = array("gm", "Gabia"); break;
		 	 case "ge": $result = array("ge", "Georgien"); break;
		 	 case "gh": $result = array("gh", "Ghana"); break;
		 	 case "gi": $result = array("gi", "Gibraltar"); break;
		 	 case "gd": $result = array("gd", "Grenada"); break;
		 	 case "gr": $result = array("gr", "Griechenland"); break;
		 	 case "gl": $result = array("gl", "Gr&ouml;nland"); break;
		 	 case "gp": $result = array("gp", "Guadeloupe"); break;
		 	 case "gu": $result = array("gu", "Guam"); break;
		 	 case "gt": $result = array("gt", "Guatemala"); break;
		 	 case "gg": $result = array("gg", "Guernsey"); break;
		 	 case "gn": $result = array("gn", "Guinea"); break;
		 	 case "gw": $result = array("gw", "Guinea-Bissau"); break;
		 	 case "gy": $result = array("gy", "Guyana"); break;
		 	 case "ht": $result = array("ht", "Haiti"); break;
		 	 case "hm": $result = array("hm", "Heard und McDonaldinseln"); break;
		 	 case "hn": $result = array("hn", "Honduras"); break;
		 	 case "hk": $result = array("hk", "Hongkong"); break;
		 	 case "in": $result = array("in", "Indien"); break;
		 	 case "id": $result = array("id", "Indonesien"); break;
		 	 case "im": $result = array("im", "Insel Man"); break;
		 	 case "iq": $result = array("iq", "Irak"); break;
		 	 case "ir": $result = array("ir", "Iran"); break;
		 	 case "ie": $result = array("ie", "Irland"); break;
		 	 case "is": $result = array("is", "Island"); break;
		 	 case "il": $result = array("il", "Israel"); break;
		 	 case "jm": $result = array("jm", "Jamaika"); break;
		 	 case "jp": $result = array("jp", "Japan"); break;
		 	 case "ye": $result = array("ye", "Jemen"); break;
		 	 case "je": $result = array("je", "Jersey"); break;
		 	 case "jo": $result = array("jo", "Jordanien"); break;
		 	 case "yu": $result = array("yu", "Jugoslawien"); break;
		 	 case "ky": $result = array("ky", "Kaimaninseln"); break;
		 	 case "kh": $result = array("kh", "Kambodscha"); break;
		 	 case "cm": $result = array("cm", "Kamerun"); break;
		 	 case "ca": $result = array("ca", "Kanada"); break;
		 	 case "ic": $result = array("ic", "Kanarische Inseln"); break;
		 	 case "cv": $result = array("cv", "Kap Verde"); break;
			 case "kz": $result = array("kz", "Kasachstan"); break;
		 	 case "qa": $result = array("qa", "Katar"); break;
		 	 case "ke": $result = array("ke", "Kenia"); break;
		 	 case "kg": $result = array("kg", "Kirgisistan"); break;
		 	 case "ki": $result = array("ki", "Kiribati"); break;
		 	 case "cc": $result = array("cc", "Kokosinseln"); break;
		 	 case "co": $result = array("co", "Kolumbien"); break;
		 	 case "km": $result = array("km", "Komoren"); break;
		 	 case "cd": $result = array("cd", "Kongo, demokratische Republik (ehem. Zaire)"); break;
		 	 case "cg": $result = array("cg", "Republik Kongo"); break;
		 	 case "kp": $result = array("kp", "Korea, demokratische Volksrepublik (Nordkorea)"); break;
		 	 case "kr": $result = array("kr", "Korea, Republik (S&uuml;dkorea)"); break;
		 	 case "hr": $result = array("hr", "Kroatien"); break;
		 	 case "cu": $result = array("cu", "Kuba"); break;
		 	 case "kw": $result = array("kw", "Kuwait"); break;
		 	 case "la": $result = array("la", "Laos"); break;
		 	 case "ls": $result = array("ls", "Lesotho"); break;
		 	 case "lv": $result = array("lv", "Lettland"); break;
		 	 case "lb": $result = array("lb", "Libanon"); break;
		 	 case "lr": $result = array("lr", "Liberia"); break;
		 	 case "ly": $result = array("ly", "Libyen"); break;
		 	 case "li": $result = array("li", "Lichtenstein"); break;
		 	 case "lt": $result = array("lt", "Litauen"); break;
		 	 case "lu": $result = array("lu", "Luxemburg"); break;
		 	 case "mo": $result = array("mo", "Macao"); break;
		 	 case "mg": $result = array("mg", "Madagaskar"); break;
		 	 case "mw": $result = array("mw", "Malawi"); break;
		 	 case "my": $result = array("my", "Malaysia"); break;
		 	 case "mv": $result = array("mv", "Malediven"); break;
		 	 case "ml": $result = array("ml", "Mali"); break;
		 	 case "mt": $result = array("mt", "Malta"); break;
		 	 case "ma": $result = array("ma", "Marokko"); break;
		 	 case "mh": $result = array("mh", "Marschallinseln"); break;
		 	 case "mq": $result = array("mq", "Martinique"); break;
		 	 case "mr": $result = array("mr", "Mauretanien"); break;
		 	 case "mu": $result = array("mu", "Mauritius"); break;
		 	 case "yt": $result = array("yt", "Mayotte"); break;
		 	 case "mk": $result = array("mk", "Mazedonien"); break;
		 	 case "mx": $result = array("mx", "Mexiko"); break;
		 	 case "fm": $result = array("fm", "Mikronesien"); break;
		 	 case "md": $result = array("md", "Moldawien"); break;
		 	 case "mc": $result = array("mc", "Monaco"); break;
		 	 case "mn": $result = array("mn", "Mongolei"); break;
		 	 case "ms": $result = array("ms", "Montserrat"); break;
		 	 case "mz": $result = array("mz", "Mosambik"); break;
		 	 case "mm": $result = array("mm", "Myanmar"); break;
		 	 case "na": $result = array("na", "Namibia"); break;
		 	 case "nr": $result = array("nr", "Nauru"); break;
		 	 case "np": $result = array("np", "Nepal"); break;
		 	 case "nc": $result = array("nc", "Neukaledonien"); break;
		 	 case "nz": $result = array("nz", "Neuseeland"); break;
		 	 case "nt": $result = array("nt", "Neutrale Zone (Saudi-Arabien und Irak)"); break;
		 	 case "ni": $result = array("ni", "Nicaragua"); break;
		 	 case "nl": $result = array("nl", "Niederlande"); break;
		 	 case "an": $result = array("an", "Niederl&auml;ndische Antillen"); break;
		 	 case "ne": $result = array("ne", "Niger"); break;
		 	 case "ng": $result = array("ng", "Nigeria"); break;
		 	 case "nu": $result = array("nu", "Niue"); break;
		 	 case "mp": $result = array("mp", "N&ouml;rdliche Marianen"); break;
		 	 case "nf": $result = array("nf", "Norfolkinsel"); break;
		 	 case "no": $result = array("no", "Norwegen"); break;
		 	 case "om": $result = array("om", "Oman"); break;
		 	 case "at": $result = array("at", "&Ouml;sterreich"); break;
		 	 case "pk": $result = array("pk", "Pakistan"); break;
		 	 case "ps": $result = array("ps", "Pal&auml;stinensische Autonomiegebiete"); break;
		 	 case "pw": $result = array("pw", "Palau"); break;
		 	 case "pa": $result = array("pa", "Panama"); break;
		 	 case "pg": $result = array("pg", "Papua-Neuginea"); break;
		 	 case "py": $result = array("py", "Paraguay"); break;
		 	 case "pe": $result = array("pe", "Peru"); break;
		 	 case "ph": $result = array("ph", "Philippinen"); break;
		 	 case "pn": $result = array("pn", "Pitcairninseln"); break;
		 	 case "pl": $result = array("pl", "Polen"); break;
		 	 case "pt": $result = array("pt", "Portugal"); break;
		 	 case "pr": $result = array("pr", "Puerto Rico"); break;
		 	 case "re": $result = array("re", "Reunion"); break;
		 	 case "rw": $result = array("rw", "Ruanda"); break;
		 	 case "ro": $result = array("ro", "Rum&auml;nien"); break;
		 	 case "ru": $result = array("ru", "Russland"); break;
		 	 case "sb": $result = array("sb", "Salomonen"); break;
		 	 case "zm": $result = array("zm", "Sambia"); break;
		 	 case "ws": $result = array("ws", "Samoa"); break;
		 	 case "sm": $result = array("sm", "San Marino"); break;
		 	 case "st": $result = array("st", "Sao Tome und Principe"); break;
		 	 case "sa": $result = array("sa", "Saudi-Arabien"); break;
		 	 case "se": $result = array("se", "Schweden"); break;
		 	 case "ch": $result = array("ch", "Schweiz"); break;
		 	 case "sn": $result = array("sn", "Senegal"); break;
		 	 case "cs": $result = array("cs", "Serbien und Montenegro"); break;
		 	 case "sc": $result = array("sc", "Seychellen"); break;
		 	 case "sl": $result = array("sl", "Sierra Leone"); break;
		 	 case "zw": $result = array("zw", "Simbabwe"); break;
		 	 case "sg": $result = array("sg", "Singapur"); break;
		 	 case "sk": $result = array("sk", "Slowakei"); break;
		 	 case "si": $result = array("si", "Slowenien"); break;
		 	 case "so": $result = array("so", "Somalia"); break;
		 	 case "es": $result = array("es", "Spanien"); break;
		 	 case "lk": $result = array("lk", "Sri Lanka"); break;
		 	 case "sh": $result = array("sh", "St. Helena"); break;
		 	 case "kn": $result = array("kn", "St. Kitts und Nevis"); break;
		 	 case "lc": $result = array("lc", "St. Lucia"); break;
		 	 case "pm": $result = array("pm", "St. Pierre und Miguelon"); break;
		 	 case "vc": $result = array("vc", "St. Vincent und die Grenadinen"); break;
		 	 case "za": $result = array("za", "S&uuml;dafrika"); break;
		 	 case "sd": $result = array("sd", "Sudan"); break;
		 	 case "gs": $result = array("gs", "S&uuml;dgeorgien und die s&uuml;dlichen Sandwichinseln"); break;
		 	 case "sr": $result = array("sr", "Suriname"); break;
		 	 case "sj": $result = array("sj", "Svalbard und Jan Mayen"); break;
		 	 case "sz": $result = array("sz", "Swasiland"); break;
		 	 case "sy": $result = array("sy", "Syrien"); break;
		 	 case "tj": $result = array("tj", "Tadschikistan"); break;
		 	 case "tw": $result = array("tw", "Taiwan"); break;
		 	 case "tz": $result = array("tz", "Tansania"); break;
		 	 case "th": $result = array("th", "Thailand"); break;
		 	 case "tl": $result = array("tl", "Timor-Leste"); break;
		 	 case "tg": $result = array("tg", "Togo"); break;
		 	 case "tk": $result = array("tk", "Takelau"); break;
		 	 case "to": $result = array("to", "Tonga"); break;
		 	 case "tt": $result = array("tt", "Trinidat und Tobago"); break;
		 	 case "ta": $result = array("ta", "Tristan da Cunha"); break;
		 	 case "td": $result = array("td", "Tschad"); break;
		 	 case "cz": $result = array("cz", "Teschechische Republik"); break;
		 	 case "cs": $result = array("cs", "Tschechoslowakei (ehemalig)"); break;
		 	 case "tn": $result = array("tn", "Tunesien"); break;
		 	 case "tr": $result = array("tr", "T&uuml;rkei"); break;
		 	 case "tm": $result = array("tm", "Turkmenistan"); break;
		 	 case "tc": $result = array("tc", "Turks- und Caicosinseln"); break;
		 	 case "tv": $result = array("tv", "Tuvalu"); break;
		 	 case "su": $result = array("su", "UdSSR (ehemalig)"); break;
		 	 case "ug": $result = array("ug", "Uganda"); break;
		 	 case "ua": $result = array("ua", "Ukraine"); break;
		 	 case "hu": $result = array("hu", "Ungarn"); break;
		 	 case "uy": $result = array("uy", "Uruguay"); break;
		 	 case "uz": $result = array("uz", "Usbekistan"); break;
		 	 case "vu": $result = array("vu", "Vanuatu"); break;
		 	 case "va": $result = array("va", "Vatikanstadt"); break;
		 	 case "ve": $result = array("ve", "Venezuela"); break;
		 	 case "ae": $result = array("ae", "Vereinigte Arabische Emirate"); break;
		 	 case "us": $result = array("us", "USA"); break;
		 	 case "gb": $result = array("gb", "Grossbritanien"); break;
		 	 case "vn": $result = array("vn", "Vietnam"); break;
		 	 case "wf": $result = array("wf", "Wallis und Futuna"); break;
		 	 case "cx": $result = array("cx", "Weihnachtsinsel"); break;
		 	 case "eh": $result = array("eh", "Westsahara"); break;
		 	 case "zr": $result = array("zr", "Demokratische Relublik Konto (ehem. Zaire)"); break;
		 	 case "cf": $result = array("cf", "Zentralafrikanische Republik"); break;
		 	 case "cy": $result = array("cy", "Zypern"); break;
		 	 default: $result = array("unknown", "unknown"); break;
		 }
		 $this->strLanguage = $result[0];
		 $this->strCountry = $result[1];
		 
		 
		 //---------------------------------------
		 // Browser / Browserversion
		 //---------------------------------------
		 if(eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version) 
		 		|| eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version) ){
		     $this->strBrowser = "Opera";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(firefox)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Firefox";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(firebird)/([0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version) 
		 		|| eregi("(firebird) ([0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Firebird";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(konqueror)/([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Konqueror";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(omniweb/)([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "OmniWeb";
			 $this->strBrowserVersion = $version[2];
		 } 
		 elseif(eregi("(webtv/)([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "WebTV";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(dillo/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Dillo";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(amaya/V)([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version) 
		 		|| eregi("(amaya/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Amaya";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(galeon/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Galeon";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Lynx";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(links) \(([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Links";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(crazy browser) ([0-9]{1,2}.[0-9]{1,3}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Crazy Browser";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(avant browser/)",$this->strHTTP_USER_AGENT)){
			  eregi("(compatible;) ([0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version);
		     $this->strBrowser = "Avant Browser";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "MSIE";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(curl)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)) {
		     $browser = "Curl";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(IBrowse)/([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "IBrowse";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(netscape)/([0-9]{1,3}.[0-9]{1,2})",$this->strHTTP_USER_AGENT,$version)){
		     $this->strBrowser = "Netscape";
		 	 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(mozilla)/([0-9]{1,2}.[0-9]{1,3})",$this->strHTTP_USER_AGENT,$version)){
				  eregi("(rv:)([0-9]{1,2}.[0-9a-z]{1,2})",$this->strHTTP_USER_AGENT,$version1);
		     $this->strBrowser = "Mozilla";
			 $this->strBrowserVersion = $version1[2];
		 }
		 elseif(eregi("mozilla/5",$this->strHTTP_USER_AGENT) 
		 		|| eregi("(Mozilla) ([0-9]{1,2})", $this->strHTTP_USER_AGENT)) {
		     $this->strBrowser = "Mozilla";
			 $this->strBrowserVersion = "";
		 }
		 elseif(eregi("bot",$this->strHTTP_USER_AGENT)){
		     $this->strBrowser = "Bot";
			 $this->strBrowserVersion = "";
		 }
		 elseif(eregi("w3m",$this->strHTTP_USER_AGENT)){
		     $this->strBrowser = "w3m";
			 $this->strBrowserVersion = "";
		 }
		 elseif(eregi("(wget)/([0-9]{1,2}.[0-9]{1,2})",$this->strHTTP_USER_AGENT, $version)){
		     $this->strBrowser = "Wget";
			 $this->strBrowserVersion = $version[2];
		 }
		 elseif(eregi("(LeechGet) ([0-9]{1,5})",$this->strHTTP_USER_AGENT, $version)){
		     $this->strBrowser = "LeechGet";
			 $this->strBrowserVersion = $version[2];
		 }
		 else{
		     $this->strBrowser = "Bot";
			 $this->strBrowserVersion= "";
		 }
	}
}
?>

