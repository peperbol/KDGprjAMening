using UnityEngine;
using System.Collections;
using UnityEngine.UI;
/// <summary>
/// pulses alpha of an image in and out
/// </summary>
[RequireComponent(typeof(Image))]
public class FadePulse : MonoBehaviour
{

    public float duration = 0.1f;
    public float stay = 0.5f;

    private Image image;
    private float timer;
    private bool isOn;

    void Start()
    {
        image = GetComponent<Image>();
    }
    float Opacity
    {
        set
        {
            Color c = image.color;
            c.a = value;
            image.color = c;
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
