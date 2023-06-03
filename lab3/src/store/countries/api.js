import Api from '@/api/index';

class Countries extends Api {

  /**
   * Вернет список всех стран
   * @returns {Promise<Response>}
   */

  countries = () => this.rest('/countries/list.json').then();

  remove = ( id ) => this.rest('/countries/delete-item',  {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify({ id }),
  }).then(() => id) // then - заглушка, пока метод ничего не возвращает

  add = ( country ) => this.rest('/countries/add-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(country),
  }).then(() => ({...country, id: new Date().getTime()})) // then - заглушка, пока метод ничего не возвращает
  
  update = ( country ) => this.rest('/countries/update-item', {
    method: 'POST',
    'Content-Type': 'application/json',
    body: JSON.stringify(country),
  }).then(() => country) // then - заглушка, пока метод ничего не возвращает

}

export default new Countries();