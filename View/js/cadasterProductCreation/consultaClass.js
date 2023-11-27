import {consultarClassificacoes, transformaMaiusculo, excluiClassi, editarClassificacao} from "./functionsProducts.js"

let btnBuscaPedido = document.getElementById('btnBuscaPedido'),
    inputBusca = document.getElementById('inputBusca'),
    sectionProducts = document.getElementById('sectionProducts')

    function criaCardDaConsulta(nomeDaClass) {
        let limiteCaracteres = 19
        let cardsClass = document.createElement('div')
        cardsClass.classList.add('cardsClass')

        let nomeClass = document.createElement('div')
        nomeClass.classList.add('nomeClass')
        //nomeClass.innerText = nomeDaClass
        
        if (nomeDaClass.length > limiteCaracteres) {
            let parteDoNome = nomeDaClass.substring(0, limiteCaracteres);
            nomeClass.innerText = parteDoNome + '...';
        } else {
            nomeClass.innerText = nomeDaClass
        }

        let divEditExclu = document.createElement('div')
        divEditExclu.classList.add('divEditExclu')
        let btnsExcluClass = document.createElement('button')
        btnsExcluClass.classList.add('btnsExcluClass')
        btnsExcluClass.innerText = 'Excluir'
        btnsExcluClass.onclick = async () => {
            const newTexto = nomeDaClass.trim()
            console.log(newTexto)
            sectionProducts.removeChild(cardsClass)
            await excluiClassi(newTexto)
        }

        let btnsEditClass = document.createElement('button')
        btnsEditClass.classList.add('btnsEditClass')
        btnsEditClass.innerText = 'Editar'
        btnsEditClass.onclick = async () => {
            let inputNomeClass = document.createElement('input')
            inputNomeClass.value = nomeDaClass
            inputNomeClass.classList.add('inputClass')

            let divHoldEditClass = document.createElement('div')
            divHoldEditClass.classList.add('divEditExclu')
            let btnsSalveEdit = document.createElement('button')
            btnsSalveEdit.classList.add('btnsEditClass')
            btnsSalveEdit.innerText = 'Salvar'
            btnsSalveEdit.onclick = async () => {
                let limpaStr = inputNomeClass.value.trim()
                if (limpaStr == '') {
                    alert("Digite algum valor")
                }
                inputNomeClass.remove()
                divHoldEditClass.remove()
                divEditExclu.append(btnsExcluClass, btnsEditClass)
                cardsClass.append(limpaStr, divEditExclu)
                await editarClassificacao(nomeDaClass, limpaStr)
            }
            let btnsCancelEdit = document.createElement('button')
            btnsCancelEdit.classList.add('btnsExcluClass')
            btnsCancelEdit.innerText = 'Cancelar'
            btnsCancelEdit.onclick = () => {
                inputNomeClass.remove()
                divHoldEditClass.remove()
                divEditExclu.append(btnsExcluClass, btnsEditClass)
                cardsClass.append(nomeClass, divEditExclu)
            }
            nomeClass.remove()
            divEditExclu.remove(btnsExcluClass, btnsEditClass)
            divHoldEditClass.append(btnsCancelEdit, btnsSalveEdit)
            cardsClass.append(inputNomeClass, divHoldEditClass)
        }

        divEditExclu.append(btnsExcluClass, btnsEditClass)
        cardsClass.append(nomeClass, divEditExclu)
        sectionProducts.appendChild(cardsClass)
    }

    let opcoes = await consultarClassificacoes();
    opcoes.forEach((e) => {
            criaCardDaConsulta(e)
    });

    btnBuscaPedido.addEventListener('click', async ()=>{
        let limpaStr = inputBusca.value.trim()
        if (limpaStr == '') {
            alert("Digite o nome da classificação")
        } else {
            sectionProducts.innerHTML = '';
        if (limpaStr) {
            let newTexto = transformaMaiusculo(limpaStr)
            newTexto.trim()
            let opcoes = await consultarClassificacoes();
            opcoes.forEach((e) => {
                if (newTexto == e || transformaMaiusculo(e).startsWith(newTexto)) {
                    criaCardDaConsulta(e)
                } else {
                    console.log("Não Encontrado")
                }
            });
            inputBusca.value = ''
        } }
    })