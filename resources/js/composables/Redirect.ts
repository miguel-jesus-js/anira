export function Redirect() {
    const router = useRouter();

    const redirect = (url, id) => {
        router.push({ name: url, params: { id } });
    };

    return { redirect };
}
