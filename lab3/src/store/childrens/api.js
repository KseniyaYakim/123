import Api from '@/api/index';

class Childrens extends Api {

  childrens = () => this.rest('/childrens/list.json');

  childrensFiltered = ( id ) => this.rest('/childrens/list-filtered', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  })

  remove = ( id ) => this.rest('/childrens/delete-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  add = ( children ) => this.rest('/childrens/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(children),
  }).then(() => ({...children, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает

  update = ( children ) => this.rest('/childrens/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(children),
  }).then(() => children) // then - заглушка, пока метод ничего не возвращает

}

export default new Childrens();