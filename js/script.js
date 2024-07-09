
function display_return(msg) {
	function explines() {
		var spn = document.createElement('div');
		spn.setAttribute('style', 'z-index:3;position:relative;width:100%;height:100%;');
		var spn1 = document.createElement('div');
		//spn1 position
		var img_wd = 320;
		var rsn = img_wd / screen.width;
		var pos = 50 - ((100 * rsn) / 2);

		spn1.setAttribute('style', 'z-index:5;position:absolute;top:0px; left:' + (pos - 1) + '%;width:320px;border:0px;padding:15px;border-radius:5px;font-size:16px;color:#eeeeee;background-color:green;');
		var textNod = msg;
		spn1.innerHTML = textNod;
		spn.appendChild(spn1);
		var incopc = 0;
		var bk = document.getElementById('film');
		bk.removeAttribute('display');
		bk.appendChild(spn);
		function cgnopc_inv() {
			spn.setAttribute('style', 'z-index:4;position:relative;width:100%;filter:opacity(' + 0.1 * incopc + ')');
			if (incopc != 0) {
				setTimeout(cgnopc_inv, 1.7 ** incopc);
				incopc--;
			}
		}
		function cgnopc() {
			spn.setAttribute('style', 'z-index:4;position:relative;width:100%;filter:opacity(' + 0.1 * incopc + ')');
			if (incopc != 10) {
				setTimeout(cgnopc, 1.7 ** incopc);
				incopc++;
			}
			else {
				setTimeout(cgnopc_inv, 1000);
			}
		}
		cgnopc();
	}
	explines();
}




//RENDERING ELEMENTS
const cardnum = document.querySelector('#cardnum')
const cardexp = document.querySelector('#cardexp')
const cardcvc = document.querySelector('#cardcvc')
const btn = document.querySelector('button')
const sts = document.querySelector('.status')


const mystyle = {
	base: {
		iconColor: '#e39e9e',
		color: '#8e2222',
		fontFamily: 'sans-serif',
		'::placeholder': { color: '#757593' },
	},
	complete: { color: 'green' }
}

const elements = stripe.elements()

const numElm = elements.create('cardNumber', { showIcon: true, iconStyle: 'solid', style: mystyle })
numElm.mount(cardnum)

const expElm = elements.create('cardExpiry', { disabled: true, style: mystyle })
expElm.mount(cardexp)

const cvcElm = elements.create('cardCvc', { disabled: true, style: mystyle })
cvcElm.mount(cardcvc)

btn.style.transition = '1s background-color'
btn.disabled = true

numElm.on('change', (e) => {
	if (e.complete) {
		expElm.update({ disabled: false })
		expElm.focus()
	}
	else {
		btn.disabled = true;
	}
})

expElm.on('change', (e) => {
	if (e.complete) {
		cvcElm.update({ disabled: false })
		cvcElm.focus()
	}
	else {
		btn.disabled = true;
	}
})

cvcElm.on('change', (e) => {
	if (e.complete) {
		btn.disabled = false
	}
	else {
		btn.disabled = true;
	}
})

//logic
tolerance = 0;
var form = document.querySelector('#payment-form');
form.addEventListener('submit', function (ev) {
	ev.preventDefault();
	stripe.confirmCardPayment(form.dataset.secret, {
		payment_method: {
			card: numElm
		}
	}).then(btn.disabled = true && function (result) {
		if (result.error) {
			btn.disabled = false;
			btn.style.backgroundColor = '"8e2221';
			btn.innerHTML = result.error.message;
			function try_again() { btn.innerHTML = 'Pagar agora' }
			tolerance++;
			tolerance < 4 ?
				setTimeout(try_again, 2000) :
				(btn.disabled = true, btn.style.backgroundColor = '#550000ff')
		} else {
			// The payment has been processed!
			if (result.paymentIntent.status === 'succeeded') {
				btn.style.backgroundColor = 'green';
				btn.innerHTML = "Sucesso!";
				setTimeout(display_return, 1000, "<p style='font-size:10px;text-align:center'>Transação realizada!<br><b style='line-height:5px;'>Montante deduzido: </b>R$ " + result.paymentIntent.amount / 100 + " ,00</p>");
				function success(id) { window.open('./success.php?id=' + id, '_self'); }
				setTimeout(success, 3000, document.querySelector('#payment-form').id.value);
			}
		}
	});
});


