export default function currencyUSD(value) {
  return new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'})
    .format(value);
}
export function currencyRUB(value) {
  return new Intl.NumberFormat('ru-RU', {style: 'currency', currency: 'RUB'})
    .format(value);
}
