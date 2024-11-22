<style>
    legend>div {
        height: 40px;
        background-color: rgb(49, 51, 59);
        color: #eee;
        line-height: 28px;
        padding: 6px 12px
    }

    legend>div.active {
        background-color: rgb(15, 125, 228);
    }

    #pageTitle {
        border: 1px solid #777;
        height: 36px;
        background-color: rgb(15, 125, 228);
        padding: 4px 18px;
        border-radius: 12px;
        font: bold 18px / 1.5 Cairo;
        color: #fff;
        text-align: right;
    }

    .quick-nav {
        display: flex;
        flex-direction: row-reverse
    }

    .quick-nav span {
        border: 1px solid #ccc;
        border-left: 0;
    }

    .quick-nav span:first-child {
        border: 1px solid #ccc;
        border-radius: 1em;
    }

    .quick-nav span:last-child {
        border-radius: 1em;
    }


    .quick-nav span:hover {
        background-color: #777;
        color: #fff;
    }

</style>
