using UnityEngine;
using System.Collections;
[ExecuteInEditMode]
public class AspectRatioAdjuster : MonoBehaviour
{
    public float width = 1080;

    RectTransform t;
    void Awake()
    {

        t = GetComponent<RectTransform>();
        Update();
    }

    void Update()
    {
        float height = ((float)Screen.height) / Screen.width * width;
        Camera.main.orthographicSize = height / 2f;
        t.sizeDelta = new Vector2(width, height);
    }

}
