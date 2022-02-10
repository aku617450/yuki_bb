import "bootstrap";
import "../scss/index.scss";

window.addEventListener('load', () => {

  index();

  window.addEventListener('click', (target) => {
    switch(target.target.className){
      case 'btn btn-primary js-create':
        create();
        break;
      case 'btn btn-info js-edit':
        edit(target.target);
        break;
      case 'btn btn-danger js-destroy':
        destroy(target.target);
        break;
    }
  })

});

/**
 * Index function
 * 見出し関数
 * 
 * @return {void}
 */
function index(){
  (async () => {
    const res = await callApi(location.protocol + '//' + location.host + '/model/index.php', 'POST', '');
    renderData(res);
  })();
}

/**
 * Create data function
 * データ挿入関数
 * 
 * @return {void}
 */
function create(){
  (async () => {
    const formData = new FormData(document.querySelector('.js-form'));
    const res = await callApi(location.protocol + '//' + location.host + '/model/create.php', 'POST', formData)
    renderData(res.data);
    document.querySelector('input[name=title]').value = '';
    document.querySelector('textarea[name=content]').value = '';
  })();
}

/**
 * Edit data function
 * データ編集関数
 * 
 * @param {Object} target
 * @return {void}
 */
function edit(target){
  const id = target.getAttribute('data-id');
  document.querySelector('.js-create').classList.add('d-none');
  document.querySelector('.js-update').classList.remove('d-none');
  if(document.querySelector('.js-create').classList.contains('d-none')){
    document.querySelectorAll('.js-edit').forEach((e) => {
      e.innerHTML = 'Cancel';
    });
  }else{
    document.querySelectorAll('.js-edit').forEach((e) => {
      e.innerHTML = 'Edit';
    });
  }
  document.querySelector('.js-update').addEventListener('click', () => {
    (async () => {
      let formData = new FormData(document.querySelector('.js-form'));
      formData.append('id', id);
      const res = await callApi(location.protocol + '//' + location.host + '/model/edit.php', 'POST', formData)
      renderData(res.data);
      document.querySelector('.js-create').classList.remove('d-none');
      document.querySelector('.js-update').classList.add('d-none');
      document.querySelector('input[name=title]').value = '';
      document.querySelector('textarea[name=content]').value = '';
    })();
  });
}

/**
 * Destroy data function
 * データ削除関数
 * 
 * @param {Object} target
 * @return {void}
 */
function destroy(target){
  (async () => {
    const id = target.getAttribute('data-id');
    let formData = new FormData();
    formData.append('id', id);
    const res = await callApi(location.protocol + '//' + location.host + '/model/destroy.php', 'POST', formData)
    renderData(res.data);
    document.querySelector('input[name=title]').value = '';
    document.querySelector('textarea[name=content]').value = '';
  })();
}

/**
 * API call function
 * API呼び出し関数
 * 
 * @param {string} url 
 * @param {string} method 
 * @param {Array} formData 
 * @return {Array}
 */
async function callApi(url, method, formData){
  const res = await fetch(url, {
    method: method,
    body: formData,
  });
  return await res.json();
}

/**
 * Data rendering function
 * データ描画関数
 * 
 * @param {string} params
 * @return {void}
 */
function renderData(params){
  document.querySelector('tbody').innerHTML = '';
  params.forEach((val, key) => {
    document.querySelector('tbody').insertAdjacentHTML('beforeend',
    `
      <tr>
        <th scope="row">${key + 1}</th>
        <td>${val.title}</td>
        <td>${val.content}</td>
        <td><button type="button" class="btn btn-info js-edit" data-id=${val.id}>Edit</button></td>
        <td><button type="button" class="btn btn-danger js-destroy" data-id=${val.id}>Destroy</button></td>
      </tr>
    `
    )
  });
}