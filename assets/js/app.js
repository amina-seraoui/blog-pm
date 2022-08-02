import '../css/app.scss'
import {Dropdown} from 'bootstrap'

document.addEventListener('DOMContentLoaded', () => {
    new App()
})

class App
{
    constructor() {
        this.enableDropdowns()
        this.handleCommentForm()
    }

    enableDropdowns()
    {
        const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        dropdownElementList.map(function (dropdownToggleEl) {
            return new Dropdown(dropdownToggleEl)
        })
    }

    handleCommentForm()
    {
        const form = document.querySelector('form[name="comment"]')
        const comments = document.getElementById('comments')
        const count = document.querySelector('h2 .comment-count')
        if (!form || !comments) return

        form.addEventListener('submit', e => {
            e.preventDefault()
            fetch('/comments/add', {
                method: 'POST',
                body: new FormData(e.target)
            })
                .then(res => res.json())
                .then(res => {
                    if (res.code === 'COMMENT_ADDED_SUCCESFULLY') {
                        comments.insertAdjacentHTML('beforebegin', res.msg)
                        count.innerText = res.count
                        form.reset()
                    }
                })
                .catch(err => console.log(err))
        })
    }

}
