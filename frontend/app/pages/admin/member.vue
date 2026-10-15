<template>
    <div class="member">
        <div class="member-content">
            <h2 class="title">会員管理</h2>
            <div class="num-search">
                <p class="num">会員数：{{ totalUser }}名</p>
                <form class="search" @submit.prevent="searchUser">
                    <input
                        v-model="search"
                        class="search-txt"
                        type="text"
                        placeholder="名前・メールアドレスで検索"
                    />
                    <button class="search-btn" type="submit">検索</button>
                </form>
            </div>
            <!-- 会員がいる場合 -->
            <table v-if="users.length !== 0" class="member-list">
                <tbody>
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>メールアドレス</th>
                        <th>予約数</th>
                        <th>詳細</th>
                    </tr>
                    <template v-for="user in users" :key="user.id">
                        <tr>
                            <td class="id-col">{{ user.id }}</td>
                            <td class="name-col">{{ user.name }}</td>
                            <td class="email-col">{{ user.email }}</td>
                            <td class="total-col">
                                {{ user.total_reservation }}
                            </td>
                            <td class="detail-col">
                                <button
                                    class="detail-btn"
                                    @click="userDetail(user.id)"
                                >
                                    詳細
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <!-- 検索結果が0件の場合 -->
            <div v-else-if="users.length === 0 && appliedSearch !== ''">
                <p>該当する会員は見つかりませんでした。</p>
            </div>
            <!-- 会員が一人もいない場合 -->
            <div v-else>
                <p>登録されている会員はいません。</p>
            </div>
            <!-- ページネーションを表示(会員がいる場合) -->
            <div v-if="users.length !== 0" class="paginate">
                <div>
                    <button class="page-btn" @click="prevPage"><</button>
                </div>
                <div v-for="page in lastPage" :key="page">
                    <button class="page-btn" @click="numPage(page)">
                        {{ page }}
                    </button>
                </div>
                <div>
                    <button class="page-btn" @click="nextPage">></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// インポート
import { ref } from "vue";

// 一般ユーザー
const users = ref([]);
// ユーザーの全体数
const totalUser = ref(0);
// 検索ワード
const search = ref("");
// ページネーション
// 現在のページ番号
const currentPage = ref(1);
// 最終ページ番号
const lastPage = ref(1);
// 検索ワード(ページネーション用)
const appliedSearch = ref("");

definePageMeta({
    layout: "admin", // 管理者用のヘッダーを表示
    middleware: "admin-auth", // 認証中のみアクセス可能にする
});

// 一般ユーザー情報の取得
const getUsers = async () => {
    try {
        const res = await adminApiFetch("http://localhost/api/admins/user", {
            method: "GET",
        });

        // APIから取得したユーザー情報を画面表示用に整形
        for (let i = 0; i < res.data.user.length; i++) {
            users.value.push({
                id: res.data.user[i].id,
                name: res.data.user[i].name,
                email: res.data.user[i].email,
                total_reservation: res.data.user[i].total_reservation,
            });
        }
        // ユーザーの全体数を取得
        totalUser.value = res.data.total_user;
        // 現在のページ番号を取得
        currentPage.value = res.meta.current_page;
        // 最後のページ番号を取得
        lastPage.value = res.meta.last_page;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// ユーザー検索
const searchUser = async () => {
    // 一度全て空にする
    users.value = [];
    try {
        const res = await adminApiFetch("http://localhost/api/admins/user", {
            method: "GET",
            query: { search: search.value },
        });

        // APIから取得したユーザー情報を画面表示用に整形
        for (let i = 0; i < res.data.user.length; i++) {
            users.value.push({
                id: res.data.user[i].id,
                name: res.data.user[i].name,
                email: res.data.user[i].email,
                total_reservation: res.data.user[i].total_reservation,
            });
        }
        // 検索ワードを取得(ページネーション用)
        appliedSearch.value = search.value;
        // ユーザーの全体数を取得
        totalUser.value = res.data.total_user;
        // 現在のページ番号を取得
        currentPage.value = res.meta.current_page;
        // 最後のページ番号を取得
        lastPage.value = res.meta.last_page;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// usersテーブルのidを持たせて、会員詳細画面へ
const userDetail = (id) => {
    return navigateTo(`/admin/user/${id}`);
};

// ページネーション
// 指定のページへ
const numPage = async (num) => {
    // 一度全て空にする
    users.value = [];
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user?page=${num}`,
            {
                method: "GET",
                query: { search: appliedSearch.value },
            },
        );

        // APIから取得したユーザー情報を画面表示用に整形
        for (let i = 0; i < res.data.user.length; i++) {
            users.value.push({
                id: res.data.user[i].id,
                name: res.data.user[i].name,
                email: res.data.user[i].email,
                total_reservation: res.data.user[i].total_reservation,
            });
        }
        // ユーザーの全体数を取得
        totalUser.value = res.data.total_user;
        // 現在のページ番号を取得
        currentPage.value = res.meta.current_page;
        // 最後のページ番号を取得
        lastPage.value = res.meta.last_page;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 前のページへ
const prevPage = async () => {
    // 1ページ戻る
    const num = currentPage.value - 1;
    // iページ戻った値が1より小さい場合、処理しない
    if (num < 1) {
        return;
    }

    // 一度全て空にする
    users.value = [];
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user?page=${num}`,
            {
                method: "GET",
                query: { search: appliedSearch.value },
            },
        );

        // APIから取得したユーザー情報を画面表示用に整形
        for (let i = 0; i < res.data.user.length; i++) {
            users.value.push({
                id: res.data.user[i].id,
                name: res.data.user[i].name,
                email: res.data.user[i].email,
                total_reservation: res.data.user[i].total_reservation,
            });
        }
        // ユーザーの全体数を取得
        totalUser.value = res.data.total_user;
        // 現在のページ番号を取得
        currentPage.value = res.meta.current_page;
        // 最後のページ番号を取得
        lastPage.value = res.meta.last_page;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 次のページへ
const nextPage = async () => {
    // 1ページ進む
    const num = currentPage.value + 1;
    // iページ進んだ値が最終ページ値より大きい場合、処理しない
    if (num > lastPage.value) {
        return;
    }
    // 一度全て空にする
    users.value = [];
    try {
        const res = await adminApiFetch(
            `http://localhost/api/admins/user?page=${num}`,
            {
                method: "GET",
                query: { search: appliedSearch.value },
            },
        );

        // APIから取得したユーザー情報を画面表示用に整形
        for (let i = 0; i < res.data.user.length; i++) {
            users.value.push({
                id: res.data.user[i].id,
                name: res.data.user[i].name,
                email: res.data.user[i].email,
                total_reservation: res.data.user[i].total_reservation,
            });
        }
        // ユーザーの全体数を取得
        totalUser.value = res.data.total_user;
        // 現在のページ番号を取得
        currentPage.value = res.meta.current_page;
        // 最後のページ番号を取得
        lastPage.value = res.meta.last_page;
    } catch (error) {
        // エラー表示
        console.error("予期せぬエラーが発生しました：", error);
        alert(`予期せぬエラーが発生しました： ${error}`);
    }
};

// 初回実行
getUsers();
</script>

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
    height: 65px;
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
    height: 65px;
    font-size: 20px;
    cursor: pointer;
}

.paginate {
    display: flex;
    justify-content: flex-end;
    width: 90%;
    margin: 10px auto;
}

.page-btn {
    padding: 15px;
    font-size: 20px;
    color: #eef9ff;
    cursor: pointer;
    background-color: #5276b8;
}
</style>
