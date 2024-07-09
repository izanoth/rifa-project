var toogle = false;
var dv2;
var iframe;
function infoup(url) {
    function transition(url) {
        if (toogle) {
            var bdy = document.getElementsByTagName('body')[0];
            var bkg = document.createElement('div');
            bkg.setAttribute('style', 'position:fixed;height:100%;width:100%;background-color:rgb(100, 100, 100);filter:opacity(0)');
            bkg.setAttribute('id', 'bkgr');
            dv2 = document.createElement('div');
            dv2.setAttribute('id', 'dv2');
            dv2.setAttribute('class', 'inner pnl-bd urlainer');
            var win_scr_w = 300 / window.screen.width;
            var win_scr_h = 450 / window.screen.height;
            var pos_w = 50 - ((100 * win_scr_w) / 2);
            var pos_h = 50 - ((100 * win_scr_h) / 2);
            dv2.setAttribute('style', 'z-index:1;position:fixed;left:' + pos_w + '%;top:' + pos_h + '%;border-radius:15px;width:300px;padding:15px;background-color:#ff7777;');
            iframe = document.createElement('iframe');
            iframe.setAttribute('src', url);
            iframe.setAttribute('width', '100%');
            iframe.setAttribute('height', '300px');
            iframe.setAttribute('style', 'border:none');
            dv2.append(iframe);
            var btn = document.createElement('button');
            btn.setAttribute('onclick', "infoup('" + url + "')");
            btn.setAttribute('class', 'btn btn-secondary');
            btn.setAttribute('style', 'display:block;margin:auto;');
            btn.innerHTML = "Fechar";
            dv2.append(btn);
            bdy.insertBefore(bkg, bdy.childNodes[0]);
            bdy.append(dv2);
            var n = 0;
            var stl2 = dv2.getAttribute('style');
            var bkg_stl = bkg.getAttribute('style');
            function incr() {
                var bkg = document.getElementById('bkgr');
                var rst = n * 0.1;
                var rstbk = ((n / 2) * 0.1);

                if (n < 10) {
                    n++;
                    stl2 = dv2.getAttribute('style');
                    dv2.setAttribute('style', stl2 + 'filter:opacity(' + rst + ');');
                    bkg.setAttribute('style', 'position:fixed;width:100%;height:100%;z-index:1;background-color:#000;filter:opacity(' + rstbk + ');');
                    setTimeout(incr, 2 ** ((n + 2) / 2));
                }
                else {
                    stl = dv2.getAttribute('style');
                    dv2.setAttribute('style', stl + 'filter:opacity(1);');
                }
            }
            incr();
        }
        else {
            var n = 10;
            if (document.getElementById('dv2')) {
                function decr() {
                    dv2 = document.getElementById('dv2');
                    stl2 = dv2.getAttribute('style');
                    bkg = document.getElementById('bkgr');
                    bkg_stl = bkg.getAttribute('style');
                    var rst = n * 0.1;
                    var rstbk = ((n / 2) * 0.1);
                    if (n > 0) {
                        n--;
                        dv2.setAttribute('style', stl2 + 'filter:opacity(' + rst + ');');
                        bkg.setAttribute('style', bkg_stl + 'filter:opacity(' + rstbk + ');');
                        setTimeout(decr, 2 ** ((n + 2) / 2));
                    }
                    else {
                        bkg.remove();
                        dv2.remove();
                    }
                }
                decr();
            }

        }
    }
    toogle ?
        (toogle = false, transition(url)) :
        (toogle = true, transition(url))
}
