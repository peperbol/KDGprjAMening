using UnityEngine;
using System.Collections;
using UnityEngine.UI;

[RequireComponent(typeof(Image))]
public class FadePulse : MonoBehaviour
{

    public float duration = 0.1f;
    public float stay = 0.5f;
    Image i;
    float timer;
    bool isOn;
    void Start()
    {
        i = GetComponent<Image>();
    }
    float Opacity
    {
        set
        {
            Color c = i.color;
            c.a = value;
            i.color = c;
        }
    }
    void Update()
    {
        timer -= Time.deltaTime;

        if (timer < duration)
        {
            Opacity = (isOn)? timer / duration : 1 - (timer / duration);
        }
        if (timer < 0)
        {
            Opacity = (isOn) ? 0 : 1;
            isOn = !isOn;
            timer += stay;
        }
    }
}
