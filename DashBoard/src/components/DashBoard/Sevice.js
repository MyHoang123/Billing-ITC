import api from './api';

export function getTotalDay() {
  return api.post('/defc9d3abbeba4eef5865829848a6a39/2c802b5a6ab183351fe92b3947f4ac70', {action: 'view', act: 'loadData'});
}

export function getHistory(Id) {
  return api.post('/defc9d3abbeba4eef5865829848a6a39/2c802b5a6ab183351fe92b3947f4ac70', {action: 'view', act: 'loadHis', Id});
}