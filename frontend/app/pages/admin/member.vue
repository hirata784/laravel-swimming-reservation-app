<template>
    <div class="member">
        <div class="member-content">
            <h2 class="title">会員管理</h2>
            <div class="num-search">
                <p class="num">会員数：7名</p>
                <div class="search">
                    <input
                        class="search-txt"
                        type="text"
                        placeholder="名前・メールアドレスで検索"
                    />
                    <button class="search-btn">検索</button>
                </div>
            </div>
            <table class="member-list">
                <tbody>
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>予約数</th>
                        <th>詳細</th>
                    </tr>
                    <template v-for="i in 7" :key="i">
                        <tr>
                            <td class="id-col">{{ i }}</td>
                            <td class="name-col">テスト</td>
                            <td class="email-col">test.example.com</td>
                            <td class="total-col">5</td>
                            <td class="detail-col">
                                <button class="detail-btn">詳細</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
p {
    margin: 0;
}

.member {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
    position: relative;
}

.member-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.num-search {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 90%;
    margin: 80px auto 10px;
}

.num {
    font-size: 20px;
}

.search {
    display: flex;
    justify-content: flex-end;
    width: 50%;
    height: 4vh;
}

.search-txt {
    width: 90%;
    padding: 10px;
    margin-right: 10px;
}

.search-btn {
    border: none;
    width: 20%;
    background-color: #55c6a9;
    color: #eef9ff;
    font-size: 20px;
    cursor: pointer;
}

.member-list {
    width: 90%;
    height: 50vh;
    margin: 0 auto;
    text-align: center;
    border-collapse: collapse;
    border: 1px solid #304654;
    color: #304654;
    font-size: 20px;
}

tr,
th,
td {
    border-bottom: 1px solid #304654;
    text-align: left;
    padding: 5px;
}

th:last-child {
    text-align: center;
}

.id-col {
    width: 5%;
}

.name-col {
    width: 20%;
}

.email-col {
    width: 50%;
}

.total-col {
    width: 10%;
}

.detail-col {
    width: 10%;
}

.detail-btn {
    border: none;
    background-color: #99b1ea;
    color: #eef9ff;
    width: 100%;
    height: 100%;
    font-size: 20px;
    cursor: pointer;
}
</style>
