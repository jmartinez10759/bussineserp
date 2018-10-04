    /* 
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */


    		
    function utf8_decode(str_data) {
      //  discuss at: http://phpjs.org/functions/utf8_decode/
      // original by: Webtoolkit.info (http://www.webtoolkit.info/)
      //    input by: Aman Gupta
      //    input by: Brett Zamir (http://brett-zamir.me)
      // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Norman "zEh" Fuchs
      // bugfixed by: hitwork
      // bugfixed by: Onno Marsman
      // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // bugfixed by: kirilloid
      //   example 1: utf8_decode('Kevin van Zonneveld');
      //   returns 1: 'Kevin van Zonneveld'

      var tmp_arr = [],
        i = 0,
        ac = 0,
        c1 = 0,
        c2 = 0,
        c3 = 0,
        c4 = 0;

      str_data += '';

      while (i < str_data.length) {
        c1 = str_data.charCodeAt(i);
        if (c1 <= 191) {
          tmp_arr[ac++] = String.fromCharCode(c1);
          i++;
        } else if (c1 <= 223) {
          c2 = str_data.charCodeAt(i + 1);
          tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
          i += 2;
        } else if (c1 <= 239) {
          // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
          c2 = str_data.charCodeAt(i + 1);
          c3 = str_data.charCodeAt(i + 2);
          tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
          i += 3;
        } else {
          c2 = str_data.charCodeAt(i + 1);
          c3 = str_data.charCodeAt(i + 2);
          c4 = str_data.charCodeAt(i + 3);
          c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
          c1 -= 0x10000;
          tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
          tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
          i += 4;
        }
      }

      return tmp_arr.join('');
    
    }


    function utf8_encode(argString) {
      //  discuss at: http://phpjs.org/functions/utf8_encode/
      // original by: Webtoolkit.info (http://www.webtoolkit.info/)
      // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: sowberry
      // improved by: Jack
      // improved by: Yves Sucaet
      // improved by: kirilloid
      // bugfixed by: Onno Marsman
      // bugfixed by: Onno Marsman
      // bugfixed by: Ulrich
      // bugfixed by: Rafal Kukawski
      // bugfixed by: kirilloid
      //   example 1: utf8_encode('Kevin van Zonneveld');
      //   returns 1: 'Kevin van Zonneveld'

      if (argString === null || typeof argString === 'undefined') {
        return '';
      }

      var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
      var utftext = '',
        start, end, stringl = 0;

      start = end = 0;
      stringl = string.length;
      for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;

        if (c1 < 128) {
          end++;
        } else if (c1 > 127 && c1 < 2048) {
          enc = String.fromCharCode(
            (c1 >> 6) | 192, (c1 & 63) | 128
          );
        } else if ((c1 & 0xF800) != 0xD800) {
          enc = String.fromCharCode(
            (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
          );
        } else { // surrogate pairs
          if ((c1 & 0xFC00) != 0xD800) {
            throw new RangeError('Unmatched trail surrogate at ' + n);
          }
          var c2 = string.charCodeAt(++n);
          if ((c2 & 0xFC00) != 0xDC00) {
            throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
          }
          c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
          enc = String.fromCharCode(
            (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
          );
        }
        if (enc !== null) {
          if (end > start) {
            utftext += string.slice(start, end);
          }
          utftext += enc;
          start = end = n + 1;
        }
      }

      if (end > start) {
        utftext += string.slice(start, stringl);
      }

      return utftext;
    
    }
    		


        //Función MD5


    function MD5(str) {
      //  discuss at: http://phpjs.org/functions/md5/
      // original by: Webtoolkit.info (http://www.webtoolkit.info/)
      // improved by: Michael White (http://getsprink.com)
      // improved by: Jack
      // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      //    input by: Brett Zamir (http://brett-zamir.me)
      // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      //  depends on: utf8_encode
      //   example 1: md5('Kevin van Zonneveld');
      //   returns 1: '6e658d4bfcb59cc13f96c14450ac40b9'

      var xl;

      var rotateLeft = function(lValue, iShiftBits) {
        return (lValue << iShiftBits) | (lValue >>> (32 - iShiftBits));
      };

      var addUnsigned = function(lX, lY) {
        var lX4, lY4, lX8, lY8, lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF) + (lY & 0x3FFFFFFF);
        if (lX4 & lY4) {
          return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        }
        if (lX4 | lY4) {
          if (lResult & 0x40000000) {
            return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
          } else {
            return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
          }
        } else {
          return (lResult ^ lX8 ^ lY8);
        }
      };

      var _F = function(x, y, z) {
        return (x & y) | ((~x) & z);
      };
      var _G = function(x, y, z) {
        return (x & z) | (y & (~z));
      };
      var _H = function(x, y, z) {
        return (x ^ y ^ z);
      };
      var _I = function(x, y, z) {
        return (y ^ (x | (~z)));
      };

      var _FF = function(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_F(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
      };

      var _GG = function(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_G(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
      };

      var _HH = function(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_H(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
      };

      var _II = function(a, b, c, d, x, s, ac) {
        a = addUnsigned(a, addUnsigned(addUnsigned(_I(b, c, d), x), ac));
        return addUnsigned(rotateLeft(a, s), b);
      };

      var convertToWordArray = function(str) {
        var lWordCount;
        var lMessageLength = str.length;
        var lNumberOfWords_temp1 = lMessageLength + 8;
        var lNumberOfWords_temp2 = (lNumberOfWords_temp1 - (lNumberOfWords_temp1 % 64)) / 64;
        var lNumberOfWords = (lNumberOfWords_temp2 + 1) * 16;
        var lWordArray = new Array(lNumberOfWords - 1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while (lByteCount < lMessageLength) {
          lWordCount = (lByteCount - (lByteCount % 4)) / 4;
          lBytePosition = (lByteCount % 4) * 8;
          lWordArray[lWordCount] = (lWordArray[lWordCount] | (str.charCodeAt(lByteCount) << lBytePosition));
          lByteCount++;
        }
        lWordCount = (lByteCount - (lByteCount % 4)) / 4;
        lBytePosition = (lByteCount % 4) * 8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80 << lBytePosition);
        lWordArray[lNumberOfWords - 2] = lMessageLength << 3;
        lWordArray[lNumberOfWords - 1] = lMessageLength >>> 29;
        return lWordArray;
      };

      var wordToHex = function(lValue) {
        var wordToHexValue = '',
          wordToHexValue_temp = '',
          lByte, lCount;
        for (lCount = 0; lCount <= 3; lCount++) {
          lByte = (lValue >>> (lCount * 8)) & 255;
          wordToHexValue_temp = '0' + lByte.toString(16);
          wordToHexValue = wordToHexValue + wordToHexValue_temp.substr(wordToHexValue_temp.length - 2, 2);
        }
        return wordToHexValue;
      };

      var x = [],
        k, AA, BB, CC, DD, a, b, c, d, S11 = 7,
        S12 = 12,
        S13 = 17,
        S14 = 22,
        S21 = 5,
        S22 = 9,
        S23 = 14,
        S24 = 20,
        S31 = 4,
        S32 = 11,
        S33 = 16,
        S34 = 23,
        S41 = 6,
        S42 = 10,
        S43 = 15,
        S44 = 21;

      str = this.utf8_encode(str);
      x = convertToWordArray(str);
      a = 0x67452301;
      b = 0xEFCDAB89;
      c = 0x98BADCFE;
      d = 0x10325476;

      xl = x.length;
      for (k = 0; k < xl; k += 16) {
        AA = a;
        BB = b;
        CC = c;
        DD = d;
        a = _FF(a, b, c, d, x[k + 0], S11, 0xD76AA478);
        d = _FF(d, a, b, c, x[k + 1], S12, 0xE8C7B756);
        c = _FF(c, d, a, b, x[k + 2], S13, 0x242070DB);
        b = _FF(b, c, d, a, x[k + 3], S14, 0xC1BDCEEE);
        a = _FF(a, b, c, d, x[k + 4], S11, 0xF57C0FAF);
        d = _FF(d, a, b, c, x[k + 5], S12, 0x4787C62A);
        c = _FF(c, d, a, b, x[k + 6], S13, 0xA8304613);
        b = _FF(b, c, d, a, x[k + 7], S14, 0xFD469501);
        a = _FF(a, b, c, d, x[k + 8], S11, 0x698098D8);
        d = _FF(d, a, b, c, x[k + 9], S12, 0x8B44F7AF);
        c = _FF(c, d, a, b, x[k + 10], S13, 0xFFFF5BB1);
        b = _FF(b, c, d, a, x[k + 11], S14, 0x895CD7BE);
        a = _FF(a, b, c, d, x[k + 12], S11, 0x6B901122);
        d = _FF(d, a, b, c, x[k + 13], S12, 0xFD987193);
        c = _FF(c, d, a, b, x[k + 14], S13, 0xA679438E);
        b = _FF(b, c, d, a, x[k + 15], S14, 0x49B40821);
        a = _GG(a, b, c, d, x[k + 1], S21, 0xF61E2562);
        d = _GG(d, a, b, c, x[k + 6], S22, 0xC040B340);
        c = _GG(c, d, a, b, x[k + 11], S23, 0x265E5A51);
        b = _GG(b, c, d, a, x[k + 0], S24, 0xE9B6C7AA);
        a = _GG(a, b, c, d, x[k + 5], S21, 0xD62F105D);
        d = _GG(d, a, b, c, x[k + 10], S22, 0x2441453);
        c = _GG(c, d, a, b, x[k + 15], S23, 0xD8A1E681);
        b = _GG(b, c, d, a, x[k + 4], S24, 0xE7D3FBC8);
        a = _GG(a, b, c, d, x[k + 9], S21, 0x21E1CDE6);
        d = _GG(d, a, b, c, x[k + 14], S22, 0xC33707D6);
        c = _GG(c, d, a, b, x[k + 3], S23, 0xF4D50D87);
        b = _GG(b, c, d, a, x[k + 8], S24, 0x455A14ED);
        a = _GG(a, b, c, d, x[k + 13], S21, 0xA9E3E905);
        d = _GG(d, a, b, c, x[k + 2], S22, 0xFCEFA3F8);
        c = _GG(c, d, a, b, x[k + 7], S23, 0x676F02D9);
        b = _GG(b, c, d, a, x[k + 12], S24, 0x8D2A4C8A);
        a = _HH(a, b, c, d, x[k + 5], S31, 0xFFFA3942);
        d = _HH(d, a, b, c, x[k + 8], S32, 0x8771F681);
        c = _HH(c, d, a, b, x[k + 11], S33, 0x6D9D6122);
        b = _HH(b, c, d, a, x[k + 14], S34, 0xFDE5380C);
        a = _HH(a, b, c, d, x[k + 1], S31, 0xA4BEEA44);
        d = _HH(d, a, b, c, x[k + 4], S32, 0x4BDECFA9);
        c = _HH(c, d, a, b, x[k + 7], S33, 0xF6BB4B60);
        b = _HH(b, c, d, a, x[k + 10], S34, 0xBEBFBC70);
        a = _HH(a, b, c, d, x[k + 13], S31, 0x289B7EC6);
        d = _HH(d, a, b, c, x[k + 0], S32, 0xEAA127FA);
        c = _HH(c, d, a, b, x[k + 3], S33, 0xD4EF3085);
        b = _HH(b, c, d, a, x[k + 6], S34, 0x4881D05);
        a = _HH(a, b, c, d, x[k + 9], S31, 0xD9D4D039);
        d = _HH(d, a, b, c, x[k + 12], S32, 0xE6DB99E5);
        c = _HH(c, d, a, b, x[k + 15], S33, 0x1FA27CF8);
        b = _HH(b, c, d, a, x[k + 2], S34, 0xC4AC5665);
        a = _II(a, b, c, d, x[k + 0], S41, 0xF4292244);
        d = _II(d, a, b, c, x[k + 7], S42, 0x432AFF97);
        c = _II(c, d, a, b, x[k + 14], S43, 0xAB9423A7);
        b = _II(b, c, d, a, x[k + 5], S44, 0xFC93A039);
        a = _II(a, b, c, d, x[k + 12], S41, 0x655B59C3);
        d = _II(d, a, b, c, x[k + 3], S42, 0x8F0CCC92);
        c = _II(c, d, a, b, x[k + 10], S43, 0xFFEFF47D);
        b = _II(b, c, d, a, x[k + 1], S44, 0x85845DD1);
        a = _II(a, b, c, d, x[k + 8], S41, 0x6FA87E4F);
        d = _II(d, a, b, c, x[k + 15], S42, 0xFE2CE6E0);
        c = _II(c, d, a, b, x[k + 6], S43, 0xA3014314);
        b = _II(b, c, d, a, x[k + 13], S44, 0x4E0811A1);
        a = _II(a, b, c, d, x[k + 4], S41, 0xF7537E82);
        d = _II(d, a, b, c, x[k + 11], S42, 0xBD3AF235);
        c = _II(c, d, a, b, x[k + 2], S43, 0x2AD7D2BB);
        b = _II(b, c, d, a, x[k + 9], S44, 0xEB86D391);
        a = addUnsigned(a, AA);
        b = addUnsigned(b, BB);
        c = addUnsigned(c, CC);
        d = addUnsigned(d, DD);
      }

      var temp = wordToHex(a) + wordToHex(b) + wordToHex(c) + wordToHex(d);

      return temp.toLowerCase();
    
    }


    Number.prototype.formatMoney = function(c, d, t){
      var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    
    };
   // $('textarea.autosize').autosize({append: "\n"});
    function updateTable(selector, jsonResponse){
        var $trSelector = $(selector);
        $('td', $trSelector).each(function() {
            $td =  $(this);
            if( $td.attr('field')!==undefined ){
              if( $td.attr('fieldType')!==undefined ){
                if( $td.attr('fieldType')=='boolean')
                 var $activo = $td.text(jsonResponse[''+$td.attr('field')]==1?'Si':'No');
                if( $td.attr('fieldType')=='currency')
                  $td.text( accounting.formatMoney(jsonResponse[''+$td.attr('field')]));
              }else
                var text = jsonResponse[''+$td.attr('field')]!=null?jsonResponse[''+$td.attr('field')]:"";
                //$td.text(utf8_decode(text));
                $td.text(text);
            }
        });
        
        var $activo = $trSelector.find("td").eq(0).html();
        var $tipo   = $trSelector.find("td").eq(5).html();

        if ($tipo=="Jefe de Oficina") {$trSelector.addClass("warning");}else{$trSelector.removeClass("warning");}
        if($activo=="No"){$trSelector.addClass("danger");}else{$trSelector.removeClass("danger");}

        $trSelector.effect("highlight");
        
    }

    function UpdateTable(selector, jsonResponse){
        var $trSelector = $(selector);
        $('td', $trSelector).each(function() {
            $td =  $(this);
            if( $td.attr('field')!==undefined ){
              if( $td.attr('fieldType')!==undefined ){
                if( $td.attr('fieldType')=='boolean')
                 $td.text(jsonResponse[''+$td.attr('field')]==1?'Si':'No');            
                if( $td.attr('fieldType')=='currency')
                  $td.text( accounting.formatMoney(jsonResponse[''+$td.attr('field')]));
              }else
                var text = jsonResponse[''+$td.attr('field')]!=null?jsonResponse[''+$td.attr('field')]:"";
                //$td.text(utf8_decode(text));
                $td.text(text);
            }
        });

       $trSelector.find("td").eq(0).html('<div class="btn-group" id="status" data-toggle="buttons">'+
                                      '<label class="btn btn-default btn-on-1 btn-sm active disabled">'+
                                      '<input type="radio" value="1" name="conf" checked="checked">SI</label>'+

                                     '<label class="btn btn-default btn-off-1 btn-sm disabled" >'+
                                     '<input type="radio" value="0" name="conf">NO</label>'+
                                  '</div>');
        $trSelector.effect("highlight");
    
    }

    sha1 = function (str) {
      //  discuss at: http://locutus.io/php/sha1/
      // original by: Webtoolkit.info (http://www.webtoolkit.info/)
      // improved by: Michael White (http://getsprink.com)
      // improved by: Kevin van Zonneveld (http://kvz.io)
      //    input by: Brett Zamir (http://brett-zamir.me)
      //      note 1: Keep in mind that in accordance with PHP, the whole string is buffered and then
      //      note 1: hashed. If available, we'd recommend using Node's native crypto modules directly
      //      note 1: in a steaming fashion for faster and more efficient hashing
      //   example 1: sha1('Kevin van Zonneveld')
      //   returns 1: '54916d2e62f65b3afa6e192e6a601cdbe5cb5897'

      var hash
      try {
        var crypto = require('crypto')
        var sha1sum = crypto.createHash('sha1')
        sha1sum.update(str)
        hash = sha1sum.digest('hex')
      } catch (e) {
        hash = undefined
      }

      if (hash !== undefined) {
        return hash
      }

      var _rotLeft = function (n, s) {
        var t4 = (n << s) | (n >>> (32 - s))
        return t4
      }

      var _cvtHex = function (val) {
        var str = ''
        var i
        var v

        for (i = 7; i >= 0; i--) {
          v = (val >>> (i * 4)) & 0x0f
          str += v.toString(16)
        }
        return str
      }

      var blockstart
      var i, j
      var W = new Array(80)
      var H0 = 0x67452301
      var H1 = 0xEFCDAB89
      var H2 = 0x98BADCFE
      var H3 = 0x10325476
      var H4 = 0xC3D2E1F0
      var A, B, C, D, E
      var temp

      // utf8_encode
      str = unescape(encodeURIComponent(str))
      var strLen = str.length

      var wordArray = []
      for (i = 0; i < strLen - 3; i += 4) {
        j = str.charCodeAt(i) << 24 |
          str.charCodeAt(i + 1) << 16 |
          str.charCodeAt(i + 2) << 8 |
          str.charCodeAt(i + 3)
        wordArray.push(j)
      }

      switch (strLen % 4) {
        case 0:
          i = 0x080000000
          break
        case 1:
          i = str.charCodeAt(strLen - 1) << 24 | 0x0800000
          break
        case 2:
          i = str.charCodeAt(strLen - 2) << 24 | str.charCodeAt(strLen - 1) << 16 | 0x08000
          break
        case 3:
          i = str.charCodeAt(strLen - 3) << 24 |
            str.charCodeAt(strLen - 2) << 16 |
            str.charCodeAt(strLen - 1) <<
          8 | 0x80
          break
      }

      wordArray.push(i)

      while ((wordArray.length % 16) !== 14) {
        wordArray.push(0)
      }

      wordArray.push(strLen >>> 29)
      wordArray.push((strLen << 3) & 0x0ffffffff)

      for (blockstart = 0; blockstart < wordArray.length; blockstart += 16) {
        for (i = 0; i < 16; i++) {
          W[i] = wordArray[blockstart + i]
        }
        for (i = 16; i <= 79; i++) {
          W[i] = _rotLeft(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1)
        }

        A = H0
        B = H1
        C = H2
        D = H3
        E = H4

        for (i = 0; i <= 19; i++) {
          temp = (_rotLeft(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff
          E = D
          D = C
          C = _rotLeft(B, 30)
          B = A
          A = temp
        }

        for (i = 20; i <= 39; i++) {
          temp = (_rotLeft(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff
          E = D
          D = C
          C = _rotLeft(B, 30)
          B = A
          A = temp
        }

        for (i = 40; i <= 59; i++) {
          temp = (_rotLeft(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff
          E = D
          D = C
          C = _rotLeft(B, 30)
          B = A
          A = temp
        }

        for (i = 60; i <= 79; i++) {
          temp = (_rotLeft(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff
          E = D
          D = C
          C = _rotLeft(B, 30)
          B = A
          A = temp
        }

        H0 = (H0 + A) & 0x0ffffffff
        H1 = (H1 + B) & 0x0ffffffff
        H2 = (H2 + C) & 0x0ffffffff
        H3 = (H3 + D) & 0x0ffffffff
        H4 = (H4 + E) & 0x0ffffffff
      }

      temp = _cvtHex(H0) + _cvtHex(H1) + _cvtHex(H2) + _cvtHex(H3) + _cvtHex(H4)
      return temp.toLowerCase()

    }

    