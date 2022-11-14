export default class CookieService {

    
    // Create cookie
    static setCookie(name, value, expires, path, domain) {
        let cookie = name + '=' + escape(value) + ';';

        if (expires) {
            // expires param is a date
            if (expires instanceof Date) {
                // If it isn't a valid date
                if (isNaN(expires.getTime())) expires = new Date();
            // expires param is the number of days
            } else {
                // console.log('nb day', expires);
                expires = new Date(new Date().getTime() + parseInt(expires) * 24 * 60 * 60 * 1000);
            }
            cookie += 'expires=' + expires.toUTCString() + ';';
        }

        if (path) cookie += 'path=' + path + ';';
        if (domain) cookie += 'domain=' + domain + ';';
        document.cookie = cookie;
    }
    

    // return cookie value if exist
    static getCookie(name) {
        let decodedCookie = decodeURIComponent(document.cookie);
        let cookies       = decodedCookie.split(';');
        
        // parse each cookie couple
        for (let i=0; i < cookies.length; i++) {
            let cookie = cookies[i];
            
            // remove prepending spaces
            while (cookie.charAt(0) == ' ') cookie = cookie.substring(1);
            
            // return value of cookie
            if (cookie.indexOf(name + '=') == 0) {
                return cookie.split('=')[1];
            }
        }
        return null;    // no cookie found
    }


    // delete cookie by name if exist
    static deleteCookie(name, path='/', domain='') {
        if (this.getCookie(name)) {
            this.setCookie(name, '', -1, path, domain);
            console.log('deleteCookie', name);
        } else {
            console.log('no cookie with this name');
        }
        // listCookies();
    }


    // list all cookies in a site
    static listCookies() {
        let decodedCookie = decodeURIComponent(document.cookie);
        let cookies       = decodedCookie.split(';');
        let list          = '';

        cookies.map((cookie, n) => list += `${n}: ${cookie}\n`);
        console.log('🍪 listCookies :\n' + list);
    }


    // ∆∆∆∆ alternate
    // static altGetCookie(name) {
    //     let cookies = document.cookie.split(';');

    //     for (let cookie of cookies) {
    //         if (cookie.indexOf(name + '=') > -1) {
    //             return cookie.split('=')[1];
    //         }
    //     }

    //     return null;
    // }
}

