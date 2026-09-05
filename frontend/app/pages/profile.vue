<template>
    <div class="profile">
        <div class="profile-content">
            <h2 class="title">プロフィール設定</h2>
            <form class="profile-form" @submit.prevent="addProfile">
                <div class="group">
                    <p class="item">性別</p>
                    <select class="sel" v-model="gender">
                        <option value="">未回答</option>
                        <option value="男性">男性</option>
                        <option value="女性">女性</option>
                        <option value="その他">その他</option>
                    </select>
                </div>
                <div class="group">
                    <p class="item">住所</p>
                    <input
                        class="txt"
                        type="text"
                        v-model="address"
                        placeholder="例：東京都新宿区西新宿2-8-1"
                    />
                </div>
                <div class="group">
                    <p class="item">電話番号</p>
                    <input
                        class="txt"
                        type="text"
                        v-model="phone"
                        placeholder="例：0901112222"
                    />
                </div>
                <button class="profile-btn" type="submit">登録する</button>
                <div class="profile-link">
                    <NuxtLink class="" to="/list">設定せず一覧画面へ</NuxtLink>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
// プロフィール入力値
const gender = ref("");
const address = ref("");
const phone = ref("");

// 認証中のみアクセス可能にする
definePageMeta({
    middleware: "auth",
});

// プロフィール設定
const addProfile = async () => {
    try {
        await apiFetch("http://localhost/api/auth/user", {
            method: "PUT",
            body: {
                gender: gender.value,
                address: address.value,
                phone: phone.value,
            },
        });
        // 予約一覧画面へ遷移する
        navigateTo("/list");
    } catch (error) {
        {
            // エラー
            console.error("予期せぬエラーが発生しました：", error);
            alert(`予期せぬエラーが発生しました： ${error}`);
        }
    }
};
</script>

<style scoped>
p {
    margin: 0;
}

.profile {
    background-color: #cce9fa;
    width: 100%;
    height: 90vh;
    text-align: center;
}

.profile-content {
    padding-top: 80px;
}

.title {
    margin: 0;
    font-size: 40px;
    color: #304654;
}

.profile-form {
    width: 60%;
    margin: 80px auto;
    padding: 30px 60px;
    border: 1px solid #304654;
    border-radius: 20px;
    background-color: #eef9ff;
}

.group {
    margin: 60px 0;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.item {
    font-size: 18px;
    color: #304654;
    text-align: left;
}

.sel {
    font-size: 18px;
    padding: 10px;
}

.txt {
    font-size: 18px;
    padding: 10px;
}

.profile-btn {
    border: none;
    background-color: #da251d;
    color: #eef9ff;
    padding: 10px 20px;
    font-size: 20px;
    cursor: pointer;
    width: 70%;
    margin-bottom: 20px;
}

.profile-link {
    margin-bottom: 47px;
}
</style>
