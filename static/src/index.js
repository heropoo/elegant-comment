import _ from 'lodash';
import './style.css';

function component() {
    let element = document.createElement('div');

    // Lodash, now imported by this script
    element.innerHTML = _.join(['Hello', 'webpack'], ' ');
    element.classList.add('red-star');

    return element;
}

document.body.appendChild(component());