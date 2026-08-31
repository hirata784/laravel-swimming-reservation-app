<template>
    <div class="modal">
        <div class="modal-content">
            <span class="close" @click="$emit('close')">&times;</span>
            <h3 class="title">パスワード変更</h3>
            <div class="item-group">
                <p class="label">現在のパスワード</p>
                <input class="txt" type="text" />
            </div>
            <div class="item-group">
                <p class="label">新しいパスワード</p>
                <input class="txt" type="text" />
            </div>
            <div class="item-group">
                <p class="label">新しいパスワード(確認)</p>
                <input class="txt" type="text" />
            </div>
            <div class="btn-area">
                <button class="update-btn" type="button">変更する</button>
                <button
                    class="cancel-btn"
                    type="button"
                    @click="$emit('close')"
                >
                    キャンセル
                </button>
            </div>
        </div>
    </div>
</template>

<style>
p {
    margin: 0;
}

.modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
}
.modal-content {
    background-color: #fefefe;
    padding: 40px;
    border: 1px solid #888;
    width: 55%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.title {
    margin: 0;
    font-size: 35px;
    color: #304654;
}

.item-group {
    margin-bottom: 50px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.label {
    font-size: 20px;
    font-weight: bold;
    color: #304654;
    text-align: left;
}

.txt {
    background-color: #f5fbff;
    font-size: 18px;
    padding: 5px;
}

.txt:focus-visible {
    background-color: #fde2e4;
}

.btn-area {
    display: flex;
    justify-content: center;
}

.update-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.cancel-btn {
    border: none;
    background-color: #a7a7a7;
    color: #eef9ff;
    padding: 10px 20px;
    margin: 0 20px 0;
    font-size: 20px;
    cursor: pointer;
    width: 45%;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
