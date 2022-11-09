void InsertSort(int pole[], int n)
{
    for (int d = 1; d <= n - 1; d++) {
        int vkladany = pole[d];
        int i = d;
        while (i > 0 && pole[i - 1] > vkladany) {
            pole[i] = pole[i - 1];
            i = i - 1;
        }
        pole[i] = vkladany;
    }
}